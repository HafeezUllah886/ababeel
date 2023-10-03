<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\accounts;
use App\Models\deposit;
use App\Models\expenses;
use App\Models\products;
use App\Models\transactions;
use App\Models\transfer;
use App\Models\withdraw;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    public function accounts()
    {
        $accounts = accounts::where('title', '!=', 'Walk-in Customer')->orderBy("type", 'asc')->get();
        return view('accounts.accounts')->with(compact('accounts'));
    }

    public function addAccount()
    {
        return view('accounts.addAccount');
    }

    public function saveAccount(request $req)
    {
        $req->validate(
            [
                'title' => 'required|unique:accounts,title'
            ]
        );

        $cat = null;
        if($req->type == 'Business')
        {
            $cat = $req->cat;
        }
        $account = accounts::create(
            [
                'title' => $req->title,
                'contact' => $req->contact,
                'type' => $req->type,
                'cat' => $cat,
                'desc' => $req->desc,
                'isActive' => 1,
            ]
        );
        $ref = getRef();
        if($req->amount > 0)
        {
            createTransaction($account->id, date('Y-m-d'), $req->amount, 0, "Initial Amount", $ref);
        }

        return back()->with('msg', "Account Created");
    }

    public function editAccount($id)
    {
        $account = accounts::find($id);
        return view('accounts.editAccount')->with(compact('account'));
    }

    public function updateAccount(request $req, $id)
    {
        $req->validate(
            [
                'title' => 'required|unique:accounts,title,' . $id
            ]
        );

        $account = accounts::find($id);
        $account->title = $req->title;
        $account->contact = $req->contact;
        $account->desc = $req->desc;
        $account->save();
        return back()->with('msg', 'Account Updated');
    }

    public function statement($id)
    {
        $account = accounts::find($id);
        return view('accounts.statement')->with(compact('account', 'id'));
    }

    public function details($id, $from, $to)
    {
        $from = Carbon::createFromFormat('d-m-Y', $from)->format('Y-m-d');
        $to = Carbon::createFromFormat('d-m-Y', $to)->format('Y-m-d');
        $items = transactions::where('account_id', $id)->where('date', '>=', $from)->where('date', '<=', $to)->get();
        $prev = transactions::where('account_id', $id)->where('date', '<', $from)->get();

        $p_balance = 0;
        foreach ($prev as $item) {
            $p_balance += $item->cr;
            $p_balance -= $item->db;
        }

        $all = transactions::where('account_id', $id)->get();

        $c_balance = 0;
        foreach ($all as $item) {
            $c_balance += $item->cr;
            $c_balance -= $item->db;
        }
        return view('accounts.statment_details')->with(compact('items', 'p_balance', 'c_balance'));
    }

    public function deposit()
    {
        $accounts = accounts::where('type', 'Business')->where('isActive', 1)->get();
        return view('accounts.deposit')->with(compact('accounts'));
    }

    public function saveDeposit(request $req)
    {
        $req->validate(
            [
                'account' => "required",
                'amount' => "required",
                'date' => "required",
            ]
        );

        $desc = "<b>Deposit</b><br/>" . $req->desc;
        $ref = getRef();
        deposit::create(
            [
                'account_id' => $req->account,
                'amount' => $req->amount,
                'date' => $req->date,
                'desc' => $req->desc,
                'ref' => $ref,
            ]
        );
        $desc = "<strong>Deposit</strong><br>" . $req->desc;
        createTransaction($req->account, $req->date, $req->amount, 0, $desc, $ref);

        return back()->with('msg', 'Amount Deposited');
    }

    public function depositDetails($from, $to,)
    {
        $from = Carbon::createFromFormat('d-m-Y', $from)->format('Y-m-d');
        $to = Carbon::createFromFormat('d-m-Y', $to)->format('Y-m-d');
        $items = deposit::where('date', '>=', $from)->where('date', '<=', $to)->orderby('id', 'desc')->get();

        return view('accounts.deposit_details')->with(compact('items'));
    }

    public function depositDelete($ref)
    {
        deposit::where('ref', $ref)->delete();
        transactions::where('ref', $ref)->delete();
        return back()->with('error', 'Transaction Deleted');
    }

    public function withdraw()
    {
        $accounts = accounts::where('type', 'Business')->where('isActive', 1)->get();
        return view('accounts.withdraw')->with(compact('accounts'));
    }

    public function saveWithdraw(request $req)
    {
        $req->validate(
            [
                'account' => "required",
                'amount' => "required",
                'date' => "required",
            ]
        );

        $desc = "<b>Withdrawal</b><br/>" . $req->desc;
        $ref = getRef();
        withdraw::create(
            [
                'account_id' => $req->account,
                'amount' => $req->amount,
                'date' => $req->date,
                'desc' => $req->desc,
                'ref' => $ref,
            ]
        );

        $desc = "<strong>Withdraw</strong><br>" . $req->desc;
        createTransaction($req->account, $req->date, 0, $req->amount, $desc, $ref);


        return back()->with('msg', 'Amount Withdrawn');
    }

    public function withdrawDetails($from, $to,)
    {
        $from = Carbon::createFromFormat('d-m-Y', $from)->format('Y-m-d');
        $to = Carbon::createFromFormat('d-m-Y', $to)->format('Y-m-d');
        $items = withdraw::where('date', '>=', $from)->where('date', '<=', $to)->orderby('id', 'desc')->get();

        return view('accounts.withdraw_details')->with(compact('items'));
    }

    public function withdrawDelete($ref)
    {
        withdraw::where('ref', $ref)->delete();
        transactions::where('ref', $ref)->delete();
        return back()->with('error', 'Transaction Deleted');
    }

    public function transfer()
    {
        $accounts = accounts::where('type', '!=', 'Supplier')->where('id', '!=', 1)->where('isActive', 1)->orderBy('type', 'asc')->get();
        $accounts1 = accounts::where('type', '!=', 'Customer')->orderBy('type', 'asc')->where('isActive', 1)->get();
        return view('accounts.transfer')->with(compact('accounts','accounts1'));
    }

    public function saveTransfer(request $req)
    {
        $req->validate(
            [
                'from' => "required",
                'to' => "required|different:from",
                'amount' => "required",
                'date' => "required",
            ]
        );

        $from = accounts::find($req->from);
        $to = accounts::find($req->to);

        $desc = "<b>Transfered to ".$to->title."</b><br/>" . $req->desc;
        $desc1 = "<b>Transfered from ".$from->title."</b><br/>" . $req->desc;
        $ref = getRef();
        transfer::create(
            [
                'from' => $req->from,
                'to' => $req->to,
                'amount' => $req->amount,
                'date' => $req->date,
                'desc' => $req->desc,
                'ref' => $ref,
            ]
        );

        if($from->type == 'Customer' && $to->type == 'Business' || $from->type == 'Business' && $to->type == 'Business' )
        {
            createTransaction($req->from, $req->date, 0, $req->amount, $desc, $ref);
            createTransaction($req->to, $req->date, $req->amount, 0, $desc1, $ref);
        }
        else
        {
            createTransaction($req->from, $req->date, 0, $req->amount, $desc, $ref);
            createTransaction($req->to, $req->date, 0, $req->amount, $desc1, $ref);
        }

        return back()->with('msg', 'Amount Transfered');
    }

    public function transferDetails($from, $to,)
    {
        $from = Carbon::createFromFormat('d-m-Y', $from)->format('Y-m-d');
        $to = Carbon::createFromFormat('d-m-Y', $to)->format('Y-m-d');
        $items = transfer::where('date', '>=', $from)->where('date', '<=', $to)->orderby('id', 'desc')->get();

        return view('accounts.transfer_details')->with(compact('items'));
    }

    public function transferDelete($ref)
    {
        transfer::where('ref', $ref)->delete();
        transactions::where('ref', $ref)->delete();
        return back()->with('error', 'Transaction Deleted');
    }

    public function expense()
    {
        $accounts = accounts::where('type', 'Business')->where('isActive', 1)->orderBy('type', 'asc')->get();
        return view('accounts.expenses')->with(compact('accounts'));
    }

    public function saveExpense(request $req)
    {
        $req->validate(
            [
                'account' => "required",
                'amount' => "required",
                'date' => "required",
            ]
        );

        $ref = getRef();
        expenses::create(
            [
                'account_id' => $req->account,
                'amount' => $req->amount,
                'date' => $req->date,
                'desc' => $req->desc,
                'ref' => $ref,
            ]
        );
        $desc = "<strong>Expense</strong><br>" . $req->desc;
        createTransaction($req->account, $req->date, 0, $req->amount, $desc, $ref);

        return back()->with('msg', 'Expense');
    }

    public function expenseDetails($from, $to,)
    {
        $from = Carbon::createFromFormat('d-m-Y', $from)->format('Y-m-d');
        $to = Carbon::createFromFormat('d-m-Y', $to)->format('Y-m-d');
        $items = expenses::where('date', '>=', $from)->where('date', '<=', $to)->orderby('id', 'desc')->get();

        return view('accounts.expense_details')->with(compact('items'));
    }

    public function expenseDelete($ref)
    {
        expenses::where('ref', $ref)->delete();
        transactions::where('ref', $ref)->delete();
        return back()->with('error', 'Expense Deleted');
    }

    public function printStatement($id, $from, $to){
        $from = Carbon::createFromFormat('d-m-Y', $from)->format('Y-m-d');
        $to = Carbon::createFromFormat('d-m-Y', $to)->format('Y-m-d');
        $items = transactions::where('account_id', $id)->where('date', '>=', $from)->where('date', '<=', $to)->get();
        $prev = transactions::where('account_id', $id)->where('date', '<', $from)->get();
        $account = accounts::find($id);

        $p_balance = 0;
        foreach ($prev as $item) {
            $p_balance += $item->cr;
            $p_balance -= $item->db;
        }

        $all = transactions::where('account_id', $id)->get();

        $c_balance = 0;
        foreach ($all as $item) {
            $c_balance += $item->cr;
            $c_balance -= $item->db;
        }
        return view('accounts.printStatement')->with(compact('items', 'p_balance', 'c_balance', 'from', 'to', 'account'));
    }

    public function ChangeStatus($id)
    {
        $account = accounts::find($id);
        if($account->isActive == 1){
            $account->isActive = 0;
        }
        else{
            $account->isActive = 1;
        }
        $account->save();
        return back()->with('msg', "Status Changed");
    }
}
