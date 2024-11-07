<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <style>
        @font-face {
            font-family: 'sarabun';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'sarabun';
            font-style: normal;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew Bold.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'sarabun';
            font-style: italic;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew Italic.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'sarabun';
            font-style: italic;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew BoldItalic.ttf') }}") format('truetype');
        }

        body {
            font-family: 'sarabun', sans-serif;
            font-size: 18px;
            margin-left: 80px;
            margin-right: 20px;
            line-height: 14px;
        }

        h3 {
            text-align: center;
            margin-top: 0;
        }

        .right {
            text-align: right;
        }

        .underline {
            text-decoration: underline;
            display: inline-block;
            width: auto;
        }

        .content-section {
            margin-bottom: 20px;
        }

        .content-section p {
            line-height: 2;
            margin: 0;
        }

        .signature-section {
            margin-top: 30px;
        }

        .signature-line {
            display: inline-block;
            width: 300px;
            border-bottom: 1px solid #000;
            margin-top: 20px;
        }

        .note {
            margin-top: 50px;
        }

        .note p {
            margin: 5px 0;
        }

        .officer-note {
            border: 1px solid #000;
            padding: 10px;
            margin-top: 30px;
            margin-bottom: 30px;
        }

        .officer-note-title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 12px;
        }

        .dotted-line {
            border-bottom: 1px dotted #000;
            width: 100%;
            height: 20px;
            margin-bottom: 5px;
        }

        .flex-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-top: 20px;
        }

        .column {
            width: 48%;
        }

        .column p {
            margin: 10px 0;
        }

        span.fullname {
            border-bottom: 1px dashed;
            padding-left: 10px;
            padding-right: 100px;
            color: blue;
        }

        span.fullname_2 {
            border-bottom: 1px dashed;
            padding-left: 10px;
            padding-right: 10px;
            color: blue;
        }

        span.age {
            border-bottom: 1px dashed;
            padding-left: 10px;
            padding-right: 10px;
            color: blue;
        }

        span.occupation {
            border-bottom: 1px dashed;
            padding-left: 10px;
            padding-right: 100px;
            color: blue;
        }

        span.house_no {
            border-bottom: 1px dashed;
            padding-left: 10px;
            padding-right: 60px;
            color: blue;
        }

        span.village_no {
            border-bottom: 1px dashed;
            padding-left: 10px;
            padding-right: 50px;
            color: blue;
        }

        span.alley {
            border-bottom: 1px dashed;
            padding-left: 10px;
            padding-right: 40px;
            color: blue;
        }

        span.road {
            border-bottom: 1px dashed;
            padding-left: 10px;
            padding-right: 50px;
            color: blue;
        }

        span.sub_district {
            border-bottom: 1px dashed;
            padding-left: 10px;
            padding-right: 50px;
            color: blue;
        }

        span.district {
            border-bottom: 1px dashed;
            padding-left: 10px;
            padding-right: 50px;
            color: blue;
        }

        span.province {
            border-bottom: 1px dashed;
            padding-left: 10px;
            padding-right: 80px;
            color: blue;
        }

        span.phone {
            border-bottom: 1px dashed;
            padding-left: 10px;
            padding-right: 150px;
            color: blue;
        }

        span.submission {
            border-bottom: 1px dashed;
            padding-left: 10px;
            padding-right: 100px;
            color: blue;
            overflow-wrap: break-word;
        }

        span.document_count {
            border-bottom: 1px dashed;
            padding-left: 10px;
            padding-right: 10px;
            color: blue;
        }

        span.location {
            border-bottom: 1px dashed;
            padding-left: 10px;
            padding-right: 20px;
            color: blue;
        }

        span.day {
            border-bottom: 1px dashed;
            padding-left: 5px;
            padding-right: 5px;
            color: blue;
        }

        span.month {
            border-bottom: 1px dashed;
            padding-left: 5px;
            padding-right: 5px;
            color: blue;
        }

        span.year {
            border-bottom: 1px dashed;
            padding-left: 5px;
            padding-right: 5px;
            color: blue;
        }

        span.submission_name {
            border-bottom: 1px dashed;
            padding-left: 5px;
            padding-right: 5px;
            color: blue;
        }

        span.item{
            border-bottom: 1px dashed;
            padding-left: 10px;
            padding-right: 100px;
            color: blue;
        }

    </style>
    <title>PDF Report</title>
</head>
<body>

    @php
    use Carbon\Carbon;

    $thaiMonths = [
    'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
    'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
    ];
    $date = Carbon::parse($form->created_at);
    $day = $date->format('d');
    $month = $thaiMonths[$date->month - 1];
    $year = $date->year + 543; // เพิ่ม 543 เพื่อให้เป็นปี พ.ศ.
    @endphp

    <div class="container">
        <h3>ฟอร์มแจ้งซ่อมแซมระบบไฟฟ้าสาธารณะหมู่บ้าน<br>องค์การบริหารส่วนตำบลทับพริก อำเภออรัญประเทศ จังหวัดสระแก้ว</h3>
        <br>

        <p class="right">วันที่<span class="day">{{ $day }}</span>เดือน<span class="month">{{ $month }}</span>พ.ศ.<span class="year"> {{ $year }}</span></p>

        <p>เรียน นายกองค์การบริหารส่วนตำบลทับพริก</p>

        <p style="margin-left: 55px;">ด้วยบ้าน<span class="house_no">{{ $form->guest_house_number}}</span>หมู่ที่<span class="village_no">{{ $form->guest_village }}</span>ซึ่งอยู่ในความรับผิดชอบขององค์การบริหารส่วน ตำบลทับพริก </p>
        <p>อำเภออรัญประเทศ จังหวักสระแก้ว ซึ้งขณะนี้ประสบปัญหาระบบไฟฟ้าสาธารณะชำรุดเสียหาย จำนวน<span class="document_count">{{ $form->location_count}}</span>จุดดังนี้</p>
        @foreach($form->locations as $location)
            <p style="margin-left: 80px;">จุดที่ {{ $loop->iteration }}. บริเวณ<span class="item">{{$location->location_name}} </p>
            @endforeach

        <p style="margin-left: 55px;">ดังนั้น เพื่อบรรเทาความเดือดร้อนใช้กับประชาชนในหมู่บ้าน จึงใคร่ขอความอนุเคราะห์ได้ โปรดพิจารณา</p>
        <p>ให้เข้าหน้าที่ที่เกี่ยวข้องดำเนินการซ่อมแซมแก้ไขให้ดีดังเดิม จักเป็นพระคุณยิ่ง</p>
        <p style="margin-left: 55px;">จึงเรียนมาเพื่อโปรดพิจารณาดำเนินการต่อไป</p>

        <p style="margin-left: 350px;">ขอแสดงความนับถือ</p>
        <p style="margin-left: 360px;">(<span class="fullname_2">{{ $form->guest_name }}</span>)</p>
        <p style="margin-left: 355px;"> <span class="fullname_2">{{ $form->guest_salutation }}{{ $form->guest_name }}</span> </p>

        <table style="width: 100%; margin-top: 10px;">
            <tr>
                <!-- คอลัมน์ซ้าย -->
                <td style="width: 50%; vertical-align: top;">
                    <p>ความเห็น...........................................................
                        <br>..........................................................................
                        <br>..........................................................................</p>
                    <br>
                    <p style="margin-left: 20px;">(...........................................................)</p>
                    <p style="margin-left: 20px;">...........................................................</p>
                </td>

                <!-- คอลัมน์ขวา -->
                <td style="width: 50%; vertical-align: top; text-align: center;">
                    <p>ความเห็น ปลัดองค์การบริหารส่วนตำบลทับพริก <br>..........................................................
                        <br>..........................................................</p>

                    <p>(นางภัทรวดี ธนะโรจชูเดช) <br>ปลัดองค์การบริหารส่วนตำบลทับพริก</p>
                    <p>คำสั่งนายก...........................................................
                        <br>..............................................................................</p>

                    <br>
                    <p>(นางรัตนากร พุฒเส็ง) <br>นายกองค์การบริหารส่วนตำบลทับพริก<br></p>
                </td>
            </tr>
        </table>
    </div>
</body>


</html>
