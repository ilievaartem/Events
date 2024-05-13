<?php

namespace App\Http\Controllers\Web;

use App\Factory\Complaint\AnswerComplaintDTOFactory;
use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Services\ComplaintService;
use App\Services\System\DataFormattersService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ComplaintsViewController extends Controller
{
    public function __construct(private readonly DataFormattersService $dataFormattersService,
                                private readonly ComplaintService      $complaintService)
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $content = $this->complaintService->showTableWith();

        return view('complaints.index', $this->dataFormattersService->formatViewResponse($content));
    }

    /**
     * @param string $id
     * @return View
     */
    public function resolveView(string $id): View
    {
        $content = $this->complaintService->show($id);

        return view('complaints.resolve', ['content' => $content]);
    }

    public function resolve(Request $request, string $complaintId, AnswerComplaintDTOFactory $answerComplaintDTOFactory): RedirectResponse
    {
        $this->complaintService->update($answerComplaintDTOFactory->make($request, $complaintId));
//        $complaint = Complaint::query()->find($id);
//
//        if (!$complaint->read_at) {
//            $complaint->read_at = now();
//        }
//        $complaint->resolve_message = request('resolve_message');
//        $complaint->resolve_description = request('resolve_description');
//        $complaint->resolved_at = now();
//
//        $complaint->save();

        return redirect()->route('complaints.index');
    }

//    /**
//     * @param $id
//     * @return RedirectResponse
//     */
//    public function resolve($id): RedirectResponse
//    {
//        $complaint = Complaint::query()->find($id);
//
//        if (!$complaint->read_at) {
//            $complaint->read_at = now();
//        }
//        $complaint->resolve_message = request('resolve_message');
//        $complaint->resolve_description = request('resolve_description');
//        $complaint->resolved_at = now();
//
//        $complaint->save();
//
//        return redirect()->route('complaints.index');
//    }
}
