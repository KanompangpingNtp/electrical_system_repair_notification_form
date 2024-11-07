<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\FormLocation;
use App\Models\FormAttachment;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use App\Models\Reply;

class AdminFormController extends Controller
{
    //

    public function adminshowform()
    {
        $forms = Form::with(['user', 'replies', 'attachments'])->get();

        // ส่งข้อมูลไปยัง view
        return view('admin_show_form.admin_show_form', compact('forms'));
    }

    public function FormEdit($id)
    {
        // ดึงข้อมูลฟอร์มจากฐานข้อมูลตาม ID
        $form = Form::findOrFail($id);

        // ดึงข้อมูลสถานที่ที่เชื่อมโยงกับฟอร์ม
        $locations = FormLocation::where('form_id', $form->id)->get();

        // ดึงข้อมูลไฟล์ที่แนบมากับฟอร์ม
        $attachments = FormAttachment::where('form_id', $form->id)->get();

        // ส่งข้อมูลไปยัง View
        return view('admin_form_edit.admin_form_edit', compact('form', 'locations', 'attachments'));
    }


    public function FormUpdate(Request $request, $id)
    {
        $request->validate([
            'request_date' => 'required|date',
            'guest_salutation' => 'nullable|string',
            'guest_name' => 'nullable|string',
            'guest_house_number' => 'nullable|string',
            'guest_village' => 'nullable|string',
            'location_count' => 'required|integer|min:1',
            'location_name' => 'required|array',
            'location_name.*' => 'required|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // ดึงข้อมูลฟอร์มที่ต้องการแก้ไข
        $form = Form::findOrFail($id);
        $form->request_date = $request->request_date;
        $form->guest_salutation = $request->guest_salutation;
        $form->guest_name = $request->guest_name;
        $form->guest_house_number = $request->guest_house_number;
        $form->guest_village = $request->guest_village;
        $form->location_count = $request->location_count;
        $form->status = 1; // หรือสถานะที่ต้องการ
        $form->save();

        // อัปเดตข้อมูลสถานที่
        FormLocation::where('form_id', $form->id)->delete(); // ลบข้อมูลสถานที่เดิมทั้งหมด

        foreach ($request->location_name as $location) {
            $formLocation = new FormLocation();
            $formLocation->form_id = $form->id;
            $formLocation->location_name = $location;
            $formLocation->save();
        }

        // อัปเดตไฟล์ที่แนบมา
        if ($request->hasFile('attachments')) {
            // ลบไฟล์เก่าออกจากที่เก็บ
            $oldAttachments = FormAttachment::where('form_id', $form->id)->get();
            foreach ($oldAttachments as $attachment) {
                // ลบไฟล์จาก storage
                Storage::disk('public')->delete($attachment->file_path);
                // ลบข้อมูลจากฐานข้อมูล
                $attachment->delete();
            }

            foreach ($request->file('attachments') as $file) {
                // สร้างชื่อไฟล์ที่ไม่ซ้ำกัน
                $filename = time() . '_' . $file->getClientOriginalName();

                // เก็บไฟล์ใน public/storage/attachments
                $path = $file->storeAs('attachments', $filename, 'public'); // ใช้ disk ที่ระบุเป็น 'public'

                // สร้างบันทึกข้อมูลใน FormAttachment
                FormAttachment::create([
                    'form_id' => $form->id,
                    'file_path' => $path,
                    'file_type' => $file->getClientOriginalExtension(),
                ]);
            }
        }

        return redirect()->back()->with('success', 'ฟอร์มถูกแก้ไขเรียบร้อยแล้ว!');
    }

    public function exportPDF($id)
    {
        $form = Form::with('locations')->find($id);  // ดึงข้อมูลฟอร์มพร้อมกับรายการที่ยืม

        // สร้าง instance ของ DomPDF ผ่าน facade Pdf
        $pdf = Pdf::loadView('admin_export_pdf.admin_export_pdf', compact('form'))
                ->setPaper('A4', 'portrait');

        // ส่งไฟล์ PDF ไปยังเบราว์เซอร์
        return $pdf->stream('แบบคำขอร้องทั่วไป' . $form->id . '.pdf');
    }

    public function updateStatus($id)
    {
        $form = Form::findOrFail($id);

        // อัปเดตสถานะ
        $form->status = 2; // หรือค่าที่คุณต้องการ
        $form->admin_name_verifier = Auth::user()->name; // เก็บ fullname ของผู้ล็อกอิน
        $form->save();

        return redirect()->back()->with('success', 'คุณได้กดรับแบบฟอร์มเรียบร้อยแล้ว');
    }

    public function adminReply(Request $request, $formId)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        // dd($request);
        // dd(auth()->id());

        Reply::create([
            'form_id' => $formId,
            'user_id' => auth()->id(),
            'reply_text' => $request->message,
        ]);

        return redirect()->back()->with('success', 'ตอบกลับสำเร็จแล้ว!');
    }
}
