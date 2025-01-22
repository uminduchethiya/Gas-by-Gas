<?php

namespace App\Http\Controllers;
use App\Models\OutletToken;
use App\Models\Token;



use Illuminate\Http\Request;

class ManagerDashboard extends Controller
{
    public function dashboard_view()
    {
        return view('manager.layout');
    }
    public function index()
    {
        $currentOutletId = auth()->user()->outlet_id;

        $outletTokens = OutletToken::select('cylinder_type_id')
            ->selectRaw('SUM(maxTokens) as totalMaxTokens, SUM(currentTokens) as totalCurrentTokens')
            ->where('outlet_id', $currentOutletId)
            ->groupBy('cylinder_type_id')
            ->with('gasCylinder')
            ->get();

        $activeTokens = Token::where('outlet_id', $currentOutletId)
            ->whereIn('status', [
                Token::STATUS_PENDING,
                Token::STATUS_SCHEDULED,
                Token::STATUS_PAYMENT_COMPLETE,
                Token::STATUS_CYLINDER_RECEIVED
            ])  // Include only active statuses
            ->join('gas_cylinders', 'gas_cylinders.id', '=', 'tokens.cylinder_type_id')  // Join with gas_cylinders table
            ->groupBy('tokens.cylinder_type_id', 'gas_cylinders.name')  // Group by cylinder type ID and name
            ->selectRaw('tokens.cylinder_type_id, gas_cylinders.name as cylinder_name, COUNT(*) as active_tokens')  // Include cylinder name and count of active tokens
            ->get();


        $pendingTokensCount = Token::where('outlet_id', $currentOutletId)
            ->where('status', Token::STATUS_PENDING)  // Filter for pending tokens
            ->count();  // Get the count of pending tokens

        return view('manager.ManagerDashboard', compact('outletTokens', 'activeTokens', 'pendingTokensCount'));
    }
}
