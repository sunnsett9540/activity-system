<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
{
    $activities = [
        "เตะฟุตบอล",
        "ปลูกต้นไม้",
        "วิ่งมาราธอน"
    ];

    return view('activities.index', compact('activities'));
}

}