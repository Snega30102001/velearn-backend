<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\LeadTimeline;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    /**
     * 1️⃣ All Leads Listing (with filters)
     */
    public function index()
    {
        $leads = Lead::with(['course', 'courseType', 'createdBy'])->orderBy('id', 'DESC')->get();

        return response()->json([
            'status' => true,
            'data'   => $leads,
        ]);
    }

    /**
     * 2️⃣ New Leads Only
     */
    public function newLeads()
    {
        try {
            $leads = Lead::where('status', 'new')
                ->with(['creator', 'course', 'courseType', 'assignedUser'])
                ->orderBy('id', 'DESC')
                ->get();

            return response()->json(['status' => true, 'data' => $leads]);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * 3️⃣ Assigned Leads for Logged-in User
     */
    public function assignedLeads()
    {
        try {
            $userId = Auth::id();

            $leads = Lead::where('assigned_to', $userId)
                ->with(['creator', 'course', 'courseType', 'assignedUser'])
                ->orderBy('id', 'DESC')
                ->get();

            return response()->json(['status' => true, 'data' => $leads]);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * 4️⃣ Store a new lead
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'            => 'required|string|max:255',
            'email'           => 'nullable|email|max:255',
            'phone'           => 'required|string|max:15',
            'source'          => 'required|string|max:50',
            'course_id'       => 'required|numeric|exists:courses,id',
            'course_type_id'  => 'required|numeric|exists:course_types,id',
            'status'          => 'required|string|max:20', 
            'event'           => 'required|string',       // timeline remark from frontend
            'event_time'      => 'required|date',
            'created_by'      => 'required|numeric|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Save Lead
        $lead = Lead::create([
            'name'            => $request->name,
            'email'           => $request->email,
            'phone'           => $request->phone,
            'source'          => $request->source,
            'course_id'       => $request->course_id,
            'course_type_id'  => $request->course_type_id,
            'status'          => $request->status,
            'created_by'      => $request->created_by,
        ]);

        // Save first timeline entry
        LeadTimeline::create([
            'lead_id'      => $lead->id,
            'event'        => 'Lead Created',
            'remarks'      => $request->event,           // Use the same 'event' field
            'event_time'   => $request->event_time,
            'added_by'     => $request->created_by,      // Make sure column exists
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Lead created successfully',
            'data'    => $lead,
        ]);
    }

    /**
     * 5️⃣ View single lead
     */
    public function show($id)
    {
        $lead = Lead::with(['course', 'courseType', 'timelines', 'createdBy'])->find($id);

        if (!$lead) {
            return response()->json([
                'status'  => false,
                'message' => 'Lead not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data'   => $lead
        ]);
    }

    /**
     * 6️⃣ Update Lead
     */
    public function update(Request $request, Lead $lead)
    {
        try {
            $lead->update($request->all());
            return response()->json(['status' => true, 'data' => $lead]);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * 7️⃣ Delete Lead
     */
    public function destroy(Lead $lead)
    {
        try {
            $lead->delete();
            return response()->json(['status' => true, 'message' => 'Lead deleted']);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * 8️⃣ Add Timeline Entry
     */
    public function addTimeline(Request $request)
    {
        try {
            $request->validate([
                'lead_id'    => 'required|exists:leads,id',
                'event'      => 'required',
                'event_time' => 'required|date',
                'added_by'   => 'required|exists:users,id',
            ]);

            $timeline = LeadTimeline::create($request->all());

            return response()->json(['status' => true, 'data' => $timeline], 201);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * 9️⃣ Dashboard Overview API
     */
    public function dashboard(Request $request)
    {
        try {
            $query = Lead::query();

            if ($request->from && $request->to) {
                $query->whereBetween('created_at', [$request->from, $request->to]);
            }

            $data = [
                'new'       => $query->where('status', 'new')->count(),
                'contacted' => $query->where('status', 'contacted')->count(),
                'hot'       => $query->where('status', 'hot')->count(),
                'warm'      => $query->where('status', 'warm')->count(),
                'cold'      => $query->where('status', 'cold')->count(),
            ];

            return response()->json(['status' => true, 'data' => $data]);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
