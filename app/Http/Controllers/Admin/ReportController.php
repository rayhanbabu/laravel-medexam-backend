<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Models\User;
use App\Models\Member;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;


class ReportController extends Controller
{
    
          public function admin_report(Request $request){ 
                $member = Member::get();
              
             return view('admin.report',["member"=>$member]);  
          }


         public function account_statement(Request $request){ 
          // try {

                $member_id=$request->member_id;

                $date1=$request->date1;
                $date2=$request->date2;
                $member=Member::find($member_id);
                $balance=Balance::where('member_id',$member_id)->latest()->first();
                $data=Balance::where('member_id',$member_id)
                ->whereBetween('date', [$date1, $date2])->orderBy('id','asc')->get();;


                $file=$member->member_name.'-'.$date1.'-'.$date2.'-Account_statement.pdf';
                $pdf = PDF::setPaper('a4','portrait')->loadView('reportprint.account_statememt', 
                       ['data'=>$data,'date1'=>$date1,'date2'=>$date2,'member'=>$member,'balance'=>$balance]);
                               //return $pdf->download($file); portrait landscape 
                   return  $pdf->stream($file, array('Attachment' => false));

               }

               //    }catch (Exception $e) {
               //         return  view('errors.error', ['error' => $e]);
               //    }
             


               public function account_debit(Request $request){ 
                  // try {
        
                        $member_id=$request->member_id;
        
                        $date1=$request->date1;
                        $date2=$request->date2;
                        $member=Member::find($member_id);
                        $balance=Balance::where('member_id',$member_id)->latest()->first();
                        $data=Debit::where('member_id',$member_id)->where('debit_status',1)
                        ->whereBetween('date',[$date1,$date2])->orderBy('id','asc')->get();

                       
                        $file=$member->member_name.'-'.$date1.'-'.$date2.'-Account_Debited.pdf';
                        $pdf = PDF::setPaper('a4','portrait')->loadView('reportprint.account_debit', 
                               ['data'=>$data,'date1'=>$date1,'date2'=>$date2,'member'=>$member,
                               'balance'=>$balance]);
                                       //return $pdf->download($file); portrait landscape 
                           return  $pdf->stream($file, array('Attachment' => false));
        
                       }
        
                       //    }catch (Exception $e) {
                       //         return  view('errors.error', ['error' => $e]);
                       //    }


                       public function account_credit(Request $request){ 
                        // try {

                              $member_id=$request->member_id;
              
                              $date1=$request->date1;
                              $date2=$request->date2;
                              $member=Member::find($member_id);
                              $balance=Balance::where('member_id',$member_id)->latest()->first();
                              $data=Credit::where('member_id',$member_id)->where('credit_status',1)
                              ->whereBetween('date',[$date1,$date2])->orderBy('id','asc')->get();
              
                              $file=$member->member_name.'-'.$date1.'-'.$date2.'-Account_credit.pdf';
                              $pdf = PDF::setPaper('a4','portrait')->loadView('reportprint.account_credit', 
                                     ['data'=>$data,'date1'=>$date1,'date2'=>$date2,'member'=>$member,'balance'=>$balance]);
                                             //return $pdf->download($file); portrait landscape 
                                 return  $pdf->stream($file, array('Attachment' => false));
              
                             }
              
                             //    }catch (Exception $e) {
                             //         return  view('errors.error', ['error' => $e]);
                             //    }



                   public function range_spend(Request $request){ 
                              // try {
      
                                    $spendcategory_id=$request->spendcategory_id;
                    
                                    $date1=$request->date1;
                                    $date2=$request->date2;
                                    $spendcategory=Spendcategory::find($spendcategory_id);
                                   
                                    $data=Spend::leftjoin('spendcategories','spendcategories.id','=','spends.spendcategory_id')
                                     ->select('spendcategories.spendcategory_name','spends.*')
                                     ->where('spend_status',1)
                                     ->whereBetween('date',[$date1,$date2])->orderBy('id','asc')->get();
                    
                                    $file=$spendcategory->spendcategory_name.'-'.$date1.'-'.$date2.'-Range_spend.pdf';
                                    $pdf = PDF::setPaper('a4','portrait')->loadView('reportprint.range_spend', 
                                           ['data'=>$data,'date1'=>$date1,'date2'=>$date2,'spendcategory'=>$spendcategory]);
                                                   //return $pdf->download($file); portrait landscape 
                                       return  $pdf->stream($file, array('Attachment' => false));
                    
                                   }
                    
                      //    }catch (Exception $e) {
                      //         return  view('errors.error', ['error' => $e]);
                      //    }      
                     


                      public function spend_credit(Request $request){ 
                        // try {

                              $spendcategory_id=$request->spendcategory_id;
              
                              $date1=$request->date1;
                              $date2=$request->date2;
                              $spendcategory=Spendcategory::find($spendcategory_id);
                             
                              $data=Spend::leftjoin('members','members.id','=','credits.member_id')
                               ->select('members.member_name','members.member_no','credits.*')
                               ->where('bank_id',$bank_id)->where('credit_status',1)
                               ->whereBetween('date',[$date1,$date2])->orderBy('id','asc')->get();
              
                              $file=$bank->bank_name.'-'.$date1.'-'.$date2.'-Range_credit.pdf';
                              $pdf = PDF::setPaper('a4','portrait')->loadView('reportprint.range_credit', 
                                     ['data'=>$data,'date1'=>$date1,'date2'=>$date2,'bank'=>$bank]);
                                             //return $pdf->download($file); portrait landscape 
                                 return  $pdf->stream($file, array('Attachment' => false));
              
                             }
              
                //    }catch (Exception $e) {
                //         return  view('errors.error', ['error' => $e]);
                //    }   
                
                
                public function all_member_report(Request $request){ 

                  $data = Member::leftjoin('plots','plots.id','=','members.plot_id')
                    ->select('plots.plot_no','members.*')
                    ->whereIN('member_status',[0,1])->orderBy('member_no','asc')->get();
                    $results = $data->map(function($order){
                         return [
                             'id' => $order->id,
                             'member_no' => $order->member_no,
                             'member_name' => $order->member_name,
                             'bangla_name' => $order->bangla_name,
                             'phone' => $order->phone,
                             'plot_no' => $order->plot_no,
                             'balance_detail' => balance_detail($order->id), // Call the function here
                        ];
                  });

                  $file = date('Y-m-d').'-member_list.pdf';
                  $pdf =PDF::setPaper('a4','portrait')->loadView('reportprint.member_list', 
                         ['results'=>$results]);
                         //return $pdf->download($file); portrait landscape 
                     return  $pdf->stream($file, array('Attachment' => false));

                }



                public function range_transaction(Request $request){ 
                    // try {

                        
                          $date1=$request->date1;
                          $date2=$request->date2;
                          
                        
                          $data=Credit::leftjoin('members','members.id','=','credits.member_id')
                           ->select('members.member_name','members.member_no','credits.*')
                            ->where('credit_status',1)
                           ->whereBetween('date',[$date1,$date2])->orderBy('id','asc')->get();
          
                          $file=$date1.'-'.$date2.'-Range_transaction.pdf';
                          $pdf = PDF::setPaper('a4','portrait')->loadView('reportprint.range_transaction', 
                                 ['data'=>$data,'date1'=>$date1,'date2'=>$date2]);
                                         //return $pdf->download($file); portrait landscape 
                             return  $pdf->stream($file, array('Attachment' => false));
          
                         }
          
            //    }catch (Exception $e) {
            //         return  view('errors.error', ['error' => $e]);
            //    }   



    }
