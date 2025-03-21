<?php
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Mail;
    use Illuminate\Support\Facades\Cookie;
    use App\Models\User;
    use App\Models\Pagecategory;
    use App\Models\Balance;


     function prx($arr){
            echo "<pre>";
            print_r($arr);
            die();
     }

     function SendEmail($email,$subject,$body,$otp,$name){
           $details = [
              'subject' => $subject,
              'otp_code'=> $otp,
                 'body' => $body,
                 'name' => $name,
            ];                
          Mail::to($email)->send(new \App\Mail\LoginMail($details));
      }


      function user_info(){
          $data = User::leftjoin('userroles','userroles.user_id','=','users.id')
          ->where('userroles.user_id',Auth::user()->id)
          ->select('userroles.admin_id','users.*')->first();
           return $data;
      }


      function supperadmin_access(){               
        if (Auth::check() && (Auth::user()->userType == 'SupperAdmin')){
               return true;
         }else{
              return false;
          }       
     }
  
        function mixed_access(){               
            if (Auth::check() && (Auth::user()->userType == 'Admin' || Auth::user()->userType == 'SupperAdmin')){
                   return true;
             }else{
                  return false;
              }       
         }

     function manager_access(){               
            if (Auth::check() && (Auth::user()->userType == 'Admin' || Auth::user()->userType == 'Manager')){
                   return true;
             }else{
                  return false;
              }       
     }

      
     function getYearsBetween2Dates(DateTime $date1, DateTime $date2, $absolute = true) {
                 $interval = $date2->diff($date1);
                 $years = $interval->y;
                 return (!$absolute && $interval->invert) ? -$years : $years;
             }
             
             
             function page_cagetory(){
                $data = Pagecategory::where('pagecategory_status',1)->get();
                return $data?$data:"";
              }
           


         function member_info(){
               $member_info=Cookie::get('member_info');
               $result=unserialize($member_info);
               return $result;
         }

          
         function balance_detail($id){
             $balance=Balance::where('member_id',$id)->latest()->first();
             $balance_amount=$balance?$balance->balance:0;  
             return $balance_amount;

         }


//       function getMinutesBetween2Dates(DateTime $date1, DateTime $date2, $absolute = true) {
//         $interval = $date2->diff($date1);
//         $minutes = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;
//         return (!$absolute and $interval->invert) ? -$minutes : $minutes;
//   }

//     function getYearsBetween2Dates(DateTime $date1, DateTime $date2, $absolute = true) {
//          $interval = $date2->diff($date1);
//          $years = $interval->y;
//          return (!$absolute && $interval->invert) ? -$years : $years;
//      }
//          function district(){
//              $data = DB::table('districts')->orderBy('name','asc')->get();
//              return $data;
//          }

//         function upazila(){
//              $data = DB::table('upazilas')->orderBy('name','asc')->get();
//              return $data;
//         }

//        function union(){
//            $data = DB::table('unions')->orderBy('name','asc')->get();
//             return $data;
//          }

    


   ?>
