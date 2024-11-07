@extends('layout.admin_layout')
@section('admin_layout')

@if ($message = Session::get('success'))
<script>
    Swal.fire({
        icon: 'success'
        , title: '{{ $message }}'
    , })

</script>
@endif

<div class="container">
    <a href="{{ route('adminshowform')}}">กลับหน้าเดิม</a><br><br>
    <h2 class="text-center">แก้ไขฟอร์ม</h2><br>
    <form action="{{ route('FormUpdate', $form->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!-- ใช้เมธอด PUT สำหรับการอัปเดตข้อมูล -->

        <!-- วันที่กรอกฟอร์ม -->
        <div class="row">
            <div class="form-group col-md-2 mb-3">
                <label for="request_date">วันที่กรอกฟอร์ม</label>
                <input type="date" id="request_date" name="request_date" class="form-control" value="{{ old('request_date', $form->request_date) }}" required>
            </div>
        </div>

        <div class="row">
            <!-- คำนำหน้า -->
            <div class="form-group col-md-2 mb-3">
                <label for="guest_salutation">คำนำหน้า<span class="text-danger">*</span></label>
                <select class="form-select" id="guest_salutation" name="guest_salutation">
                    <option value="" disabled>เลือกคำนำหน้า</option>
                    <option value="นาย" {{ $form->guest_salutation == 'นาย' ? 'selected' : '' }}>นาย</option>
                    <option value="นาง" {{ $form->guest_salutation == 'นาง' ? 'selected' : '' }}>นาง</option>
                    <option value="นางสาว" {{ $form->guest_salutation == 'นางสาว' ? 'selected' : '' }}>นางสาว</option>
                </select>
            </div>

            <!-- ชื่อ-นามสกุล -->
            <div class="form-group col-md-4 mb-3">
                <label for="guest_name">ชื่อ-นามสกุล</label>
                <input type="text" id="guest_name" name="guest_name" class="form-control" value="{{ old('guest_name', $form->guest_name) }}" placeholder="โปรดระบุ" required>
            </div>
        </div>

        <div class="row">
            <!-- บ้านเลขที่ -->
            <div class="form-group col-md-3 mb-3">
                <label for="guest_house_number">บ้านเลขที่</label>
                <input type="text" id="guest_house_number" name="guest_house_number" class="form-control" value="{{ old('guest_house_number', $form->guest_house_number) }}" placeholder="โปรดระบุ" required>
            </div>

            <!-- หมู่ที่ -->
            <div class="form-group col-md-3 mb-3">
                <label for="guest_village">หมู่ที่</label>
                <input type="text" id="guest_village" name="guest_village" class="form-control" value="{{ old('guest_village', $form->guest_village) }}" placeholder="โปรดระบุ" required>
            </div>

            <!-- จำนวนจุดบริเวณ -->
            <div class="form-group col-md-2 mb-3">
                <label for="location_count">จำนวนจุดบริเวณ</label>
                <input type="number" id="location_count" name="location_count" class="form-control" value="{{ old('location_count', $form->location_count) }}" required min="1" placeholder="โปรดระบุ">
            </div>
        </div>

        <div class="row">
            <!-- ชื่อจุดบริเวณ -->
            <div class="form-group col-md-5 mb-3">
                <label for="location_name">ชื่อจุดบริเวณ (ระบุหลายจุดได้)</label>
                @foreach($form->locations as $location)
                <!-- แสดงชื่อจุดบริเวณที่มีอยู่ -->
                <input type="text" name="location_name[]" class="form-control mb-2" value="{{ $location->location_name }}" required>
                @endforeach
                <button type="button" class="btn btn-secondary btn-sm mt-2" id="add_location">เพิ่มจุดบริเวณ</button>
            </div>
        </div>

        <div class="row">
            <div id="location_fields" class="col-md-5 mb-2"></div>
        </div>

        <div class="row">
            <div class="form-group col-md-3 mb-3">
                <label for="attachments">ไฟล์แนบ</label>
                <input type="file" name="attachments[]" class="form-control" multiple>
            </div>
        </div>

        <div class="row">
            <div>
                <label>ไฟล์ที่แนบก่อนหน้านั้น : </label>
                @if(isset($attachments) && $attachments->isNotEmpty())
                @foreach($attachments as $attachment)
                <!-- แสดงชื่อไฟล์และลิงก์สำหรับดาวน์โหลด -->
                <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank">
                    {{ $attachment->file_path }}
                </a>
                @endforeach
                @endif
            </div>
        </div>
        <br>

        <button type="submit" class="btn btn-primary">อัปเดตข้อมูล</button>
    </form>

    <script>
        document.getElementById('add_location').addEventListener('click', function() {
            var locationField = document.createElement('input');
            locationField.type = 'text';
            locationField.name = 'location_name[]';
            locationField.classList.add('form-control');
            locationField.required = true;
            document.getElementById('location_fields').appendChild(locationField);
        });

    </script>
@endsection
