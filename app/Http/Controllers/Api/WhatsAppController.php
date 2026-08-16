
<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WhatsAppController extends Controller {
 // Mode 1: Link - frontend cukup buka wa.me
 // Mode 2: API Resmi (Fonnte/Wablas/WA Business)
 public function send(Request $r){
   $r->validate(['phone'=>'required','message'=>'required']);
   $phone = $this->formatPhone($r->phone);
   $mode = env('WHATSAPP_MODE','link');

   if($mode==='link'){
     return response()->json([
       'mode'=>'link',
       'url'=>"https://wa.me/$phone?text=".urlencode($r->message)
     ]);
   }

   // Mode API
   $res = Http::withHeaders(['Authorization'=>env('WHATSAPP_API_KEY')])
     ->post(env('WHATSAPP_API_URL'),[
       'target'=>$phone,
       'message'=>$r->message
     ]);

   return response()->json(['mode'=>'api','result'=>$res->json()]);
 }

 private function formatPhone($no){
   $no = preg_replace('/[^0-9]/','',$no);
   if(substr($no,0,1)=='0') $no='62'.substr($no,1);
   if(substr($no,0,2)!='62') $no='62'.$no;
   return $no;
 }
}
