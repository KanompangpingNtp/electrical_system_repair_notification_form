<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\FormLocation;
use App\Models\FormAttachment;

class FormController extends Controller
{
    //
    public function FormIndex()
    {
        return view('users_form.users_form');
    }

    public function FormCreate(Request $request)
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

        // Create Form
        $form = new Form();
        $form->user_id = auth()->user()->id ?? null;
        $form->request_date = $request->request_date;
        $form->status = 1;
        $form->guest_salutation = $request->guest_salutation;
        $form->guest_name = $request->guest_name;
        $form->guest_house_number = $request->guest_house_number;
        $form->guest_village = $request->guest_village;
        $form->location_count = $request->location_count;
        $form->save();

        // Store Locations
        foreach ($request->location_name as $location) {
            $formLocation = new FormLocation();
            $formLocation->form_id = $form->id;
            $formLocation->location_name = $location;
            $formLocation->save();
        }

        // Store Attachments
        if ($request->hasFile('attachments')) {
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

        return redirect()->back()->with('success', 'ฟอร์มถูกส่งเรียบร้อยแล้ว!');
    }
}
