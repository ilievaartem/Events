<?php

namespace App\Http\Controllers\Web;

use App\Exceptions\NotFoundException;
use App\Factory\Complaint\AnswerComplaintDTOFactory;
use App\Factory\Complaint\FilterComplaintDTOFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Complaints\ComplaintFilterRequest;
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
     * @param ComplaintFilterRequest $request
     * @param FilterComplaintDTOFactory $complaintDTOFactory
     * @return View
     */
    public function index(ComplaintFilterRequest $request, FilterComplaintDTOFactory $complaintDTOFactory): View
    {
        $content = $this->complaintService->filter($complaintDTOFactory->make($request));

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

    /**
     * @param string $id
     * @return RedirectResponse
     * @throws NotFoundException
     */
    public function read(string $id): RedirectResponse
    {
        $this->complaintService->read($id);

        return redirect()->route('complaints.index');
    }

    /**
     * @param Request $request
     * @param string $complaintId
     * @param AnswerComplaintDTOFactory $answerComplaintDTOFactory
     * @return RedirectResponse
     * @throws NotFoundException
     */
    public function resolve(Request $request, string $complaintId, AnswerComplaintDTOFactory $answerComplaintDTOFactory): RedirectResponse
    {
        $this->complaintService->update($answerComplaintDTOFactory->make($request, $complaintId));

        return redirect()->route('complaints.index');
    }
}
