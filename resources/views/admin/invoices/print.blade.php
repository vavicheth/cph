<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice Print</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('print/style_print.css')}}">

    <style>
        table, th, td {
            border: 1px solid black;
        }

        .print{
            page-break-after: always;

        }

    </style>
</head>

<body style="background: rgb(204,204,204);" class="print">

<page size='A4'>
    <div align="center" class="pt-3">
        <a style="font-size: 13pt" class="fcontent">ព្រះរាជាណាចក្រកម្ពុជា</a><br>
        <a style="font-size: 12pt" class="fcontent">ជាតិ សាសនា ព្រះមហាក្សត្រ</a><br>
        <div style="width: 120px; align-self: center">
            <hr style="border: double">
        </div>
    </div>

    <div id="logo">
        <a class='fcontent ml-3'>មន្ទីរពេទ្យកាល់ម៉ែត</a><br>
        <a class='fcontent ml-3'> &nbsp; ផ្នែកឱសថស្ថាន</a>
        
    </div>

    <div align="center" style="padding-top: 10px; font-size: 13pt" class="fcontent"><a><u>វិក្កយបត្រ</u> </a><br></div>
    <div class="pt-2" style="padding-left: 30px;">
        <a class='fcontent'>
        អ្នកជំងឺឈ្មោះ &nbsp; &nbsp; &nbsp; : {{$patient->name}} <br>
        ភេទ អាយុ &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : {{$patient->gender == 1 ? 'ប្រុស' : 'ស្រី'}}, {{$patient->age}}ឆ្នាំ<br>
        ប្រភព &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;​ &nbsp; : {{$invoice->invstate->state}}</a>
    </div>

    <div id="table" class="p-2">
        <table class="m-3" width="93%" style="font-size: 13px;">
            <thead style="vertical-align: center !important;">
            <tr align="center" class="fcontent">
                <th style="padding: 3px" width="6%">ល.រ</th>
                <th style="padding: 3px" width="44%">រាយមុខឱសថ</th>
                <th style="padding: 3px" width="10%">ប្រភេទ</th>
                <th style="padding: 3px" width="10%">ចំនួន</th>
                <th style="padding: 3px" width="15%">តម្លៃឯកត្តា</th>
                <th style="padding: 3px" width="15%">តម្លៃសរុប</th>

            </tr>
            </thead>

            <tbody>

            <?php $i=1;  ?>
            @if (count($invoicedetails) > 0)
                @foreach ($invoicedetails as $invoicedetail)
                    <tr data-entry-id="{{ $invoicedetail->id }}">
                        <td field-key='no' align="center" style="padding: 3px">{{$i}}</td>
                        <?php $i=$i+1; ?>
                        <td field-key='medicine_id' style="padding:3px; padding-left: 5px">{{ $invoicedetail->medicine->name }}</td>
                        <td field-key='type' align="center" style="padding: 3px">{{ $invoicedetail->type }}</td>
                        <td field-key='qty' align="center" style="padding: 3px">{{ $invoicedetail->qty }}</td>
                        <td field-key='unit_price' align="right" style="padding: 3px; padding-right: 5px">{{ $invoicedetail->unit_price }}</td>
                        <td field-key='total' align="right" style="padding: 3px; padding-right: 5px">{{ $invoicedetail->total }}</td>

                    </tr>
                @endforeach
            @endif
            </tbody>

            <tfoot align="right" >
                <tr>
                    <td colspan="5" align="right" style="padding-right: 5px"><b>សុរប USD:</b></td>
                    <td style="padding-right: 5px"><b>{{number_format($invoice->invoicedetail->sum('total'),2)}}</b></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="mr-5 pull-right" style="white-space: pre-line; text-align: right" >
        <a class='fcontent' style="font-size: 11pt">ភ្នំពេញ ថ្ងៃទី {{\Carbon\Carbon::parse($invoice->date)->format('d') }} ខែ{{$m_kh}} ឆ្នាំ{{\Carbon\Carbon::parse($invoice->date)->format('Y') }}</a><br>
        <!-- <a class='fcontent' style="font-size: 11pt">ផ្នែកឱសថស្ថាន  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</a><br><br> -->

        <a class='fcontent pt-5' style="font-size: 11pt">{{\Illuminate\Support\Facades\Auth::user()->name_kh}}  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</a><br>

    </div>


</page>



</body>

<script  type="text/javascript">

    window.print();

</script>

</html>
