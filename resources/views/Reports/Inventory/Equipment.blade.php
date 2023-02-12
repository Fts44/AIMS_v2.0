<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $filename }}</title>
</head>
<body>
    <style>
        * {
            font-size: 12px;
            font-family: 'Times';
        }
        .title{
            text-align:center;
            font-size: 13px;
        }
        table, td, th {
            border: 1px solid black;
        }
        table tr th {
            text-align:center;
        }
        table{
            border-collapse: collapse;
            width: 100%;
        }
        table.no-border, table.no-border th, table.no-border td {
            border: none;
        }
    </style>

    <table class="no-border">
        <tr>
            <th width="10%"></th> <th width="10%"></th> <th width="10%"></th> <th width="10%"></th> <th width="10%"></th>
            <th width="10%"></th> <th width="10%"></th> <th width="10%"></th> <th width="10%"></th> <th width="10%"></th>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td style="text-align: right;">
                <img src="image/bsu-logo.png" alt="logo" style="width: 60px;">
            </td>
            <td colspan="4" class="title">
                BATANGAS STATE UNIVERSITY-ARASOF<br>
                NASUGBU, BATANGAS<br><br>

                <b>Inventory of Equipment For FY: {{ $year }}</b>
            </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>

    <br>   
    <div style="page-break-inside: avoid;">
        <table cellpadding="2">
            <tr>
                <th scope="col" rowspan="2" width="4%">QTY</th>
                <th scope="col" rowspan="2" width="4%">UNIT</th>
                <th scope="col" rowspan="2" width="10%">DESCRIPTION</th>
                <th rowspan="1" colspan="12">MONTH</th>
            </tr>
            <tr>
                <th scope="col" rowspan="1">Jan</th>
                <th scope="col" rowspan="1">Feb</th>
                <th scope="col" rowspan="1">Mar</th>
                <th scope="col" rowspan="1">Apr</th>
                <th scope="col" rowspan="1">May</th>
                <th scope="col" rowspan="1">Jun</th>
                <th scope="col" rowspan="1">Jul</th>
                <th scope="col" rowspan="1">Aug</th>
                <th scope="col" rowspan="1">Sep</th>
                <th scope="col" rowspan="1">Oct</th>
                <th scope="col" rowspan="1">Nov</th>
                <th scope="col" rowspan="1">Dec</th>
            </tr>
            <tbody>
                @php $category = ''; @endphp
                @if(sizeof($items)>0)
                    @foreach($items as $item)
                        @if($item->jan_1>0 || $item->jan_0>0 || $item->feb_1>0 || $item->feb_0>0 || $item->mar_1>0 || $item->mar_0>0 || $item->apr_1>0 || $item->apr_0>0 || 
                        $item->may_1>0 || $item->may_0>0 || $item->jun_1>0 || $item->jun_0>0 || $item->jul_1>0 || $item->jul_0>0 || $item->aug_1>0 || $item->aug_0>0 || 
                        $item->sep_1>0 || $item->sep_0>0 || $item->oct_1>0 || $item->oct_0>0 || $item->nov_1>0 || $item->nov_0>0 || $item->dec_1>0 || $item->dec_0>0 )
                            @if($category != $item->ieid_category)
                                @php $category = $item->ieid_category @endphp
                            <tr>
                                    <td colspan="15" style="font-weight: bold; text-align: center;">{{ strtoupper($item->ieid_category).' (Category)' }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td>{{ $item->qty }}</td>
                                <td>{{ $item->ieid_unit }}</td>
                                <td>
                                    {{ $item->ien_name }}
                                    @if($item->iet_type!='none')
                                        <br> {{ $item->iet_type }}
                                    @endif
                                    @if($item->ieb_brand!='none')
                                        <br> {{ $item->ieb_brand }}
                                    @endif
                                    @if($item->iep_place!='none')
                                        <br> {{ $item->iep_place }}
                                    @endif
                                </td>
                                <td>
                                    @if($year==date('Y'))
                                        @if(date('m')>=1)
                                            @if(($item->jan_1+$item->jan_0)>0)
                                                {{ 'Working: '.$item->jan_1 }} <br>
                                                {{ 'Not: '.$item->jan_0 }} <br>
                                                {{ 'Total: '.($item->jan_1+$item->jan_0) }}
                                            @endif
                                        @endif
                                    @else
                                        @if(($item->jan_1+$item->jan_0)>0)
                                            {{ 'Working: '.$item->jan_1 }} <br>
                                            {{ 'Not: '.$item->jan_0 }} <br>
                                            {{ 'Total: '.($item->jan_1+$item->jan_0) }}
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if($year==date('Y'))
                                        @if(date('m')>=2)
                                            @if(($item->feb_1+$item->feb_0)>0)
                                                {{ 'Working: '.$item->feb_1 }} <br>
                                                {{ 'Not: '.$item->feb_0 }} <br>
                                                {{ 'Total: '.($item->feb_1+$item->feb_0) }}
                                            @endif
                                        @endif
                                    @else
                                        @if(($item->feb_1+$item->feb_0)>0)
                                            {{ 'Working: '.$item->feb_1 }} <br>
                                            {{ 'Not: '.$item->feb_0 }} <br>
                                            {{ 'Total: '.($item->feb_1+$item->feb_0) }}
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if($year==date('Y'))
                                        @if(date('m')>=3)
                                            @if(($item->mar_1+$item->mar_0)>0)
                                                {{ 'Working: '.$item->mar_1 }} <br>
                                                {{ 'Not: '.$item->mar_0 }} <br>
                                                {{ 'Total: '.($item->mar_1+$item->mar_0) }}
                                            @endif
                                        @endif
                                    @elseif($year < date('Y'))
                                        @if(($item->mar_1+$item->mar_0)>0)
                                            {{ 'Working: '.$item->mar_1 }} <br>
                                            {{ 'Not: '.$item->mar_0 }} <br>
                                            {{ 'Total: '.($item->mar_1+$item->mar_0) }}
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if($year==date('Y'))
                                        @if(date('m')>=4)
                                            @if(($item->apr_1+$item->apr_0)>0)
                                                {{ 'Working: '.$item->apr_1 }} <br>
                                                {{ 'Not: '.$item->apr_0 }} <br>
                                                {{ 'Total: '.($item->apr_1+$item->apr_0) }}
                                            @endif
                                        @endif
                                    @elseif($year < date('Y'))
                                        @if(($item->apr_1+$item->apr_0)>0)
                                            {{ 'Working: '.$item->apr_1 }} <br>
                                            {{ 'Not: '.$item->apr_0 }} <br>
                                            {{ 'Total: '.($item->apr_1+$item->apr_0) }}
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if($year==date('Y'))
                                        @if(date('m')>=5)
                                            @if(($item->may_1+$item->may_0)>0)
                                                {{ 'Working: '.$item->may_1 }} <br>
                                                {{ 'Not: '.$item->may_0 }} <br>
                                                {{ 'Total: '.($item->may_1+$item->may_0) }}
                                            @endif
                                        @endif
                                    @elseif($year < date('Y'))
                                        @if(($item->may_1+$item->may_0)>0)
                                            {{ 'Working: '.$item->may_1 }} <br>
                                            {{ 'Not: '.$item->may_0 }} <br>
                                            {{ 'Total: '.($item->may_1+$item->may_0) }}
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if($year==date('Y'))
                                        @if(date('m')>=6)
                                            @if(($item->jun_1+$item->jun_0)>0)
                                                {{ 'Working: '.$item->jun_1 }} <br>
                                                {{ 'Not: '.$item->jun_0 }} <br>
                                                {{ 'Total: '.($item->jun_1+$item->jun_0) }}
                                            @endif
                                        @endif
                                    @elseif($year < date('Y'))
                                        @if(($item->jun_1+$item->jun_0)>0)
                                            {{ 'Working: '.$item->jun_1 }} <br>
                                            {{ 'Not: '.$item->jun_0 }} <br>
                                            {{ 'Total: '.($item->jun_1+$item->jun_0) }}
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if($year==date('Y'))
                                        @if(date('m')>=7)
                                            @if(($item->jul_1+$item->jul_0)>0)
                                                {{ 'Working: '.$item->jul_1 }} <br>
                                                {{ 'Not: '.$item->jul_0 }} <br>
                                                {{ 'Total: '.($item->jul_1+$item->jul_0) }}
                                            @endif
                                        @endif
                                    @elseif($year < date('Y'))
                                        @if(($item->jul_1+$item->jul_0)>0)
                                            {{ 'Working: '.$item->jul_1 }} <br>
                                            {{ 'Not: '.$item->jul_0 }} <br>
                                            {{ 'Total: '.($item->jul_1+$item->jul_0) }}
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if($year==date('Y'))
                                        @if(date('m')>=8)
                                            @if(($item->aug_1+$item->aug_0)>0)
                                                {{ 'Working: '.$item->aug_1 }} <br>
                                                {{ 'Not: '.$item->aug_0 }} <br>
                                                {{ 'Total: '.($item->aug_1+$item->aug_0) }}
                                            @endif
                                        @endif
                                    @elseif($year < date('Y'))
                                        @if(($item->aug_1+$item->aug_0)>0)
                                            {{ 'Working: '.$item->aug_1 }} <br>
                                            {{ 'Not: '.$item->aug_0 }} <br>
                                            {{ 'Total: '.($item->aug_1+$item->aug_0) }}
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if($year==date('Y'))
                                        @if(date('m')>=9)
                                            @if(($item->sep_1+$item->sep_0)>0)
                                                {{ 'Working: '.$item->sep_1 }} <br>
                                                {{ 'Not: '.$item->sep_0 }} <br>
                                                {{ 'Total: '.($item->sep_1+$item->sep_0) }}
                                            @endif
                                        @endif
                                    @elseif($year < date('Y'))
                                        @if(($item->sep_1+$item->sep_0)>0)
                                            {{ 'Working: '.$item->sep_1 }} <br>
                                            {{ 'Not: '.$item->sep_0 }} <br>
                                            {{ 'Total: '.($item->sep_1+$item->sep_0) }}
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if($year==date('Y'))
                                        @if(date('m')>=10)
                                            @if(($item->oct_1+$item->oct_0)>0)
                                                {{ 'Working: '.$item->oct_1 }} <br>
                                                {{ 'Not: '.$item->oct_0 }} <br>
                                                {{ 'Total: '.($item->oct_1+$item->oct_0) }}
                                            @endif
                                        @endif
                                    @elseif($year < date('Y'))
                                        @if(($item->oct_1+$item->oct_0)>0)
                                            {{ 'Working: '.$item->oct_1 }} <br>
                                            {{ 'Not: '.$item->oct_0 }} <br>
                                            {{ 'Total: '.($item->oct_1+$item->oct_0) }}
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if($year==date('Y'))
                                        @if(date('m')>=11)
                                            @if(($item->nov_1+$item->nov_0)>0)
                                                {{ 'Working: '.$item->nov_1 }} <br>
                                                {{ 'Not: '.$item->nov_0 }} <br>
                                                {{ 'Total: '.($item->nov_1+$item->nov_0) }}
                                            @endif
                                        @endif
                                    @elseif($year < date('Y'))
                                        @if(($item->nov_1+$item->nov_0)>0)
                                            {{ 'Working: '.$item->nov_1 }} <br>
                                            {{ 'Not: '.$item->nov_0 }} <br>
                                            {{ 'Total: '.($item->nov_1+$item->nov_0) }}
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if($year==date('Y'))
                                        @if(date('m')>=12)
                                            @if(($item->dec_1+$item->dec_0)>0)
                                                {{ 'Working: '.$item->dec_1 }} <br>
                                                {{ 'Not: '.$item->dec_0 }} <br>
                                                {{ 'Total: '.($item->dec_1+$item->dec_0) }}
                                            @endif
                                        @endif
                                    @elseif($year < date('Y'))
                                        @if(($item->dec_1+$item->dec_0)>0)
                                            {{ 'Working: '.$item->dec_1 }} <br>
                                            {{ 'Not: '.$item->dec_0 }} <br>
                                            {{ 'Total: '.($item->dec_1+$item->dec_0) }}
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            @endif
        </table>
    </div>
</body>
</html>