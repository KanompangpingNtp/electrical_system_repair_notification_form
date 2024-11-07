@extends('layout.users_layout')
@section('user_layout')

@if ($message = Session::get('success'))
<script>
    Swal.fire({
        icon: 'success'
        , title: '{{ $message }}'
    , })

</script>
@endif

<div class="container">
    <h3 class="text-center">กรอกข้อมูลฟอร์มแจ้งซ่อมแซม</h3><br>

    <form action="{{ route('FormCreate') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group col-md-2 mb-3">
            <label for="request_date">วันที่กรอกฟอร์ม</label>
            <input type="date" id="request_date" name="request_date" class="form-control" required>
        </div>

        <div class="row">
            <div class="form-group col-md-2 mb-3">
                <label for="guest_salutation">คำนำหน้า<span class="text-danger">*</span></label>
                <select class="form-select" id="guest_salutation" name="guest_salutation">
                    <option value="" selected disabled>เลือกคำนำหน้า</option>
                    <option value="นาย">นาย</option>
                    <option value="นาง">นาง</option>
                    <option value="นางสาว">นางสาว</option>
                </select>
            </div>

            <div class="form-group col-md-4 mb-3">
                <label for="guest_name">ชื่อ-นามสกุล</label>
                <input type="text" id="guest_name" name="guest_name" class="form-control" placeholder="โปรดระบุ" required>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-3 mb-3">
                <label for="guest_house_number">บ้านเลขที่</label>
                <input type="text" id="guest_house_number" name="guest_house_number" class="form-control" placeholder="โปรดระบุ" required>
            </div>

            <div class="form-group col-md-3 mb-3">
                <label for="guest_village">หมู่ที่</label>
                <input type="text" id="guest_village" name="guest_village" class="form-control" placeholder="โปรดระบุ" required>
            </div>

            <div class="form-group col-md-2 mb-3">
                <label for="location_count">จำนวนจุดบริเวณ</label>
                <input type="number" id="location_count" name="location_count" class="form-control" required min="1" placeholder="โปรดระบุ">
            </div>
        </div>

        <div class="form-group col-md-4 mb-3">
            <label for="location_name">ชื่อจุดบริเวณ (ระบุหลายจุดได้)</label>
            <button type="button" class="btn btn-secondary btn-sm mb-2" id="add_location" >เพิ่มจุดบริเวณ</button>
            <input type="text" name="location_name[]" class="form-control" placeholder="โปรดระบุ" required >
        </div>

        <div id="location_fields" class="col-md-4 " ></div>

        <div class="form-group col-md-3 mb-3">
            <label for="attachments">ไฟล์แนบ</label>
            <input type="file" name="attachments[]" class="form-control" multiple>
        </div>

        <button type="submit" class="btn btn-primary">ส่งข้อมูล</button>
    </form>
</div>

<script>
    document.getElementById('add_location').addEventListener('click', function() {
        var locationField = document.createElement('input');
        locationField.type = 'text';
        locationField.name = 'location_name[]';
        locationField.classList.add('form-control');
        locationField.placeholder = 'โปรดระบุ';
        locationField.required = true;
        document.getElementById('location_fields').appendChild(locationField);
    });
</script>

@endsection
