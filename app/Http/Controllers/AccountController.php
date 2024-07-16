<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) $this->getPayments($request);
        return view('account.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item' => 'required|string',
            'type' => 'required|string',
            'user' => 'required|string',
            'amount' => 'required|integer',
        ]);

        $create = Account::create($validated);

        if ($create) {
            return response()->json(['message' => 'Payment ' . $request->item . ' Added Successfully!', 'status' => 'success', 'title' => 'Added!'], 201);
        } else return response()->json(['message' => 'Failed to add payment ' . $request->item, 'status' => 'error', 'title' => 'Failed!'], 450);
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Account $account)
    {
        return response()->json(['message' => 'success', 'account' => $account], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Account $account)
    {
        $validated = $request->validate([
            'item' => 'required|string',
            'type' => 'required|string',
            'user' => 'required|string',
            'amount' => 'required|integer',
        ]);

        $updated = $account->update($validated);

        if ($updated) {
            return response()->json(['message' => 'Payment ' . $account->item . ' Updated successfully!', 'title' => 'Update', 'status' => 'success'], 201);
        }

        return response()->json(['message' => 'Failed to update payment ' . $account->item, 'title' => 'Failed', 'status' => 'error'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        if ($account->delete()) {
            return response()->json(['message' => 'Payment ' . $account->item . ' Deleted successfully!', 'status' => 'success', 'title' => 'Deleted'], 201);
        }
        return response()->json(['message' => 'Failed to delete payment ' . $account->item, 'status' => 'error', 'title' => 'Failed!'], 200);
    }

    public function getPayments($request)
    {
        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page
        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');
        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value
        // Total records
        $totalRecords = Account::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Account::select('count(*) as allcount')
            ->where('item', 'like', '%' . $searchValue . '%')
            ->orwhere('amount', 'like', '%' . $searchValue . '%')
            ->count();
        // Fetch records
        $records = Account::where('item', 'like', '%' . $searchValue . '%')
            ->orwhere('amount', 'like', '%' . $searchValue . '%')
            ->select('accounts.*')
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $totalIncome = Account::where('type', 'Income')->sum('amount');
        $totalExpense = Account::where('type', 'Expense')->sum('amount');
        $isAdmin = auth()->user()->user_type == 'Admin';

        $data_arr = array();
        foreach ($records as $record) {
            $id = $record->id;

            $item = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->item . '</span>
                        </span>
                    </div>';

            $user = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->user . '</span>
                        </span>
                    </div>';

            $record->type == 'Income' ? $type = "<span class='badge badge-success'>Inc</span>" : $type = "<span class='badge badge-danger'>Exp</span>";


            $amount = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->amount . '</span>
                        </span>
                    </div>';

            $data_arr[] = array(
                "id" => $id,
                "item" => $item,
                "type" => $type,
                "user" => $user,
                "amount" => $amount,
                "action" => $id,
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
            "totalIncome" => $totalIncome,
            "totalExpense" => $totalExpense,
            "isAdmin" => $isAdmin,
        );
        echo json_encode($response);
        exit;
    }
}
