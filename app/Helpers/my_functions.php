<?php

use App\Models\accounts;
use App\Models\activityLog;
use App\Models\expenses;
use App\Models\inflow;
use App\Models\inflowDetails;
use App\Models\outflow;
use App\Models\outflowDetails;
use App\Models\ref;
use App\Models\settings;
use App\Models\trans;
use App\Models\transactions;
use Carbon\Carbon;


function save_activity($desc){
    if(auth()->user()->username != 'SuperAdmin')
    {
        $save = activityLog::create([
            'user_id' => auth()->user()->id,
            'desc' => $desc
        ]);
    }

}

function googleTrans($string){
    if(session()->get('locale') == 'en'){
        return $string;
    }
    else{
        return GoogleTranslate::trans($string,\App::getLocale());
    }

}

function getRef(){
    $ref = ref::first();
    if($ref){
        $ref->ref = $ref->ref + 1;
    }
    else{
        $ref = new ref();
        $ref->ref = 1;
    }
    $ref->save();
    return $ref->ref;
}



function createTransaction($id, $date, $cr, $db, $desc, $ref){
    transactions::create(
        [
            'account_id' => $id,
            'date' => $date,
            'cr' => $cr,
            'db' => $db,
            'desc' => $desc,
            'ref' => $ref
        ]
    );
}


function updateTransaction($id, $cr, $db, $ref){
    $up = transactions::where('account_id', $id)->where('ref', $ref)->update(
        [
            'cr' => $cr,
            'db' => $db,
        ]
    );

}

function updateInflowTrans($b_id){

    $bill = inflow::find($b_id);
    if(!$bill){
        $item = inflowDetails::find($b_id);
        $bill = inflow::find($item->inflow->id);
    }
    $total_amount = 0;
    foreach($bill->details as $detail){
        $amount = $detail->price * $detail->qty;
        $total_amount += $amount;
    }

    if($bill->isPaid == 'yes'){
        $acct_id = $bill->paidFrom;
        updateTransaction($acct_id, 0, $total_amount, $bill->ref);
        echo "yes";
    }
    else
    {
        $acct_id = $bill->from;
        updateTransaction($acct_id, $total_amount, 0, $bill->ref);
        echo $bill->ref;
    }
}


function updateOutflowTrans($b_id){

    $bill = outflow::find($b_id);
    if(!$bill){
        $item = outflowDetails::find($b_id);
        $bill = outflow::find($item->outflow->id);
    }
    $total_amount = 0;
    foreach($bill->details as $detail){
        if($detail->unit == 'Piece')
        {
            $amount = $detail->sqf * $detail->qty * $detail->price;
        }
        else
        {
            $amount = $detail->price * $detail->qty;
        }
        $total_amount += $amount;
    }
    $g_total = $total_amount - $bill->discount;
    transactions::where('ref', $bill->ref)->delete();
    $desc_yes = "Payment received of Invoice no. " . $bill->id;
    $desc_no = "Pending Amount of Invoice no. " . $bill->id;
    $desc_partial = "Partial Amount of Invoice no. " . $bill->id;

    if($bill->isPaid == 'yes'){
        createTransaction($bill->paidIn, $bill->date, $g_total, 0, $desc_yes, $bill->ref);
    }
    elseif($bill->isPaid == 'no'){
        createTransaction($bill->to, $bill->date, $g_total, 0, $desc_no, $bill->ref);
    }
    else
    {
        createTransaction($bill->to, $bill->date, $g_total, $bill->amountPaid, $desc_no, $bill->ref);
        createTransaction($bill->paidIn, $bill->date, $bill->amountPaid, 0, $desc_no, $bill->ref);
    }
}


function calculateSQF($unit, $width, $length){
    $unitConversion = [
        'Feet' => 1,
        'Meter' => 3.28084, // For example, 1 meter is approximately 3.28084 feet
        'Inch' => 0.0833333, // For example, 1 inch is approximately 0.0833333 feet
    ];

    // Convert the dimensions to standardized feet
    $standardLength = $length * $unitConversion[$unit];
    $standardWidth = $width * $unitConversion[$unit];

    // Calculate the square footage
    return $standardLength * $standardWidth;
}


function monthlyExpense(){
    $currentMonth = date('m');
    $data = expenses::whereRaw('MONTH(date) = ?', [$currentMonth])
      ->sum('amount');
      return $data;
}

function monthlySale(){
    $currentMonth = date('m');
    $data = outflow::whereRaw('MONTH(date) = ?', [$currentMonth])->get();
    $sale_amount = 0;
    $discounts = 0;
     foreach ($data as $sale){
        $details = outflowDetails::where('bill_id', $sale->id)->get();
        $discounts += $sale->discount;
        foreach ($details as $detail){
            if($detail->unit == 'Piece'){
                $sale_amount += $detail->sqf * $detail->qty * $detail->price;
            }
            else{
                $sale_amount += $detail->qty * $detail->price;
            }
        }
     }
      return $sale_amount - $discounts;
}

function customerDues(){
    $accounts = accounts::where('type', 'customer')->get();
    $balance = 0;
    foreach($accounts as $account){
        $cr = transactions::where('account_id', $account->id)->sum('cr');
        $db = transactions::where('account_id', $account->id)->sum('db');

        $balance += $cr - $db;
    }

    return $balance;
}

function supplierDues(){
    $accounts = accounts::where('type', 'supplier')->get();
    $balance = 0;
    foreach($accounts as $account){
        $cr = transactions::where('account_id', $account->id)->sum('cr');
        $db = transactions::where('account_id', $account->id)->sum('db');

        $balance += $cr - $db;
    }

    return $balance;
}

function totalCash()
{
    $accounts = accounts::where('cat', 'Cash')->get();
    $balance = 0;
    foreach ($accounts as $account){
        $cr = transactions::where('account_id', $account->id)->sum('cr');
        $db = transactions::where('account_id', $account->id)->sum('db');

        $balance += $cr - $db;
    }

    return $balance;
}


function totalBank()
{
    $accounts = accounts::where('cat', 'Bank')->get();
    $balance = 0;
    foreach ($accounts as $account){
        $cr = transactions::where('account_id', $account->id)->sum('cr');
        $db = transactions::where('account_id', $account->id)->sum('db');

        $balance += $cr - $db;
    }

    return $balance;
}

function i_e(){
    $i_e = transactions::select(
        DB::raw('MONTH(date) as month'),
        DB::raw('YEAR(date) as year'),
        DB::raw('SUM(cr) as total_income'),
        DB::raw('SUM(db) as total_expense')
    )
    ->join('accounts', 'transactions.account_id', '=', 'accounts.id')
    ->where('accounts.type', 'Business')
    ->where('transactions.date', '>=', Carbon::now()->subMonths(12))
    ->groupBy('month', 'year')
    ->get();

    return $i_e;
}

function getInitials($string) {
    $words = explode(' ', $string);
    $initials = '';

    if (count($words) === 1) {
        $initials = substr($words[0], 0, 3);
    } else {
        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }

        // Limit the initials to 3 characters
        $initials = substr($initials, 0, 3);
    }

    return $initials;
}

function getInvoiceTotal($invoice)
{
    $bill = outflow::with('details')->find($invoice);
    $total = 0;
    foreach($bill->details as $item)
    {
        if($item->unit == 'Roll')
        {
            $total += $item->qty * $item->price;
        }
        else{
            $total += ($item->sqf * $item->qty) * $item->price;
        }
    }
    return $total - $bill->discount;
}

function getSettings(){
    return settings::first();
}
