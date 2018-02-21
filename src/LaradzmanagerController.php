<?php

namespace Codiiv\Laradzmanager;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class LaradzmanagerController extends Controller
{
  /**
     * generateRandom
     * @param  integer $length Length of the string to be returned  - Default 10
     * @return string   A random string of the specified length
     */
    public static function generateRandom($length = 16, $numeric=false) {
        if($numeric){
          $chars = '0123456789';
        }else{
          $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        }
        $count = mb_strlen($chars);

        for ($i = 0, $result = ''; $i < $length; $i++) {
            $index = rand(0, $count - 1);
            $result .= mb_substr($chars, $index, 1);
        }

        return $result;
    }
  /**
  * function slugify
  * Description: This function takes a text string and returns a unique slug
  * Variables: takes $text as input
  */
  static public function slugify($text)
  {
      $normalizeChars = array(
          'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj','Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A',
          'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
          'Ï'=>'I', 'Ñ'=>'N', 'Ń'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
          'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
          'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
          'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ń'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
          'ú'=>'u', 'û'=>'u', 'ü'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ƒ'=>'f',
          'ă'=>'a', 'î'=>'i', 'â'=>'a', 'ș'=>'s', 'ț'=>'t', 'Ă'=>'A', 'Î'=>'I', 'Â'=>'A', 'Ș'=>'S', 'Ț'=>'T',
      );

      //Output: E A I A I A I A I C O E O E O E O O e U e U i U i U o Y o a u a y c
      $text = strtr($text, $normalizeChars);

      // replace non letter or digits by -
      $text = preg_replace('~[^\pL\d]+~u', '-', $text);
      // transliterate
      $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
      // remove unwanted characters
      $text = preg_replace('~[^-\w]+~', '', $text);
      // trim
      $text = trim($text, '-');
      // remove duplicate -
      $text = preg_replace('~-+~', '-', $text);
      // lowercase
      $text = strtolower($text);


   if (empty($text)) {
      return 'n-a';
    }else{
      return $text;
    }
  }
  public static function media_exists($defaults=array("field"=>'id','value'=>'')){
    $post = DB::table('media')->where($defaults['field'] , '=', $defaults['value'])->first();
    if($post)
      return true;
    else
      return false;
  }
  public static function recursiveSlug($slug){
    $slug = self::slugify($slug);
    $poExists = self::media_exists(
              array(
                "field"=>"media_slug",
                "value"=>self::slugify($slug)
                )
              );
      if($poExists){
        $newSlug = self::recursiveSlug($slug.'-1');
      }else{
        $newSlug =  $slug;
      }
      return $newSlug;
  }
  public static function insert_media($post=array(
    "media_author"=>1,
    "media_date"=>"",
    "closing_date"=>"",
    "media_content"=>"",
    "media_title"=>"",
    "media_status"=>"publish",
    "postcode" => "",
    "media_type" => "attachment",
    "media_parent"=>0,
    "media_url"  => "",
    )){

    $datex=date_create($post["closing_date"]);
    $closing_date =  date_format($datex,"Y-m-d H:i:s");
    $table  = 'media';
    $postSlug = self::slugify($post['media_title']);

    $newpost = DB::table($table)->insertGetId([
      'media_title'   => $post['media_title'],
      'media_author'  => $post['media_author'],
      'media_date'    => date("Y-m-d H:i:s"),
      'media_date_gmt'=> gmdate("Y-m-d H:i:s"),
      'closing_date'  => $closing_date,
      'media_content' => $post['media_content'],
      'media_slug'    => $postSlug,
      'media_type'    => $post['media_type'],
      'media_url'     => $post['media_url'],
      'media_status'  => $post['media_status'],
      'media_parent'  => $post['media_parent'],
      'postcode'      => self::generateRandom(16),
      'guid'          => self::slugify($post['media_title']),
      'created_at'    => date("Y-m-d H:i:s"),
      'updated_at'    => date("Y-m-d H:i:s"),
      ]);
      return $newpost;
  }

  function loadMediaManager(){
    return view("laradzmanager::laradzmanager");
  }
  /**
   * Generate Image upload View
   *
   * @return void
   */

  public function dropzone(){

      return view('laradzmanager::dropzone-view');
  }
  /**
   * Image Upload Code
   *
   * @return void
   */

  public function dropzoneStore(Request $request)

  {
      $userid = auth()->user()->id;
      $image  = $request->file('file');

      $imageName = time().$image->getClientOriginalName();

      $extension = $image->getClientOriginalExtension();

      $newFullName = $imageName.'.'.$extension;

      $path = config('laradzmanager.uploads_path', public_path('uploads'));

      $moved = $image->move($path,$newFullName);

      $newMedia = self::insert_media([
        "media_author"=>$userid,
        "media_date"=>date("Y-m-d H:i:s"),
        "closing_date"=>date("Y-m-d H:i:s"),
        "media_content"=>"",
        "media_title"=>$imageName,
        "media_status"=>"publish",
        "media_type"=>"attachment",
        "postcode" => self::generateRandom(16),
        "media_parent"=>0,
        "media_url"  => $imageName,
      ]);
      return response()->json(['media'=>$imageName, 'fullfile'=>$newFullName, 'id'=>$newMedia]);

  }
}
