<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
</head>
<body>
    <style>
        * {
            font-size: 13px;
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

                <b>{{ $title }}</b>
            </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>

    <br>   

    <table cellpadding="2">
        <tr>
            <th scope="col" width="25%">Medicine</th>
            <th scope="col" width="25%">Stock-In</th>
            <th scope="col" width="25%">Stock-Out</th>
            <th scope="col" width="25%">Available</th>
        </tr>
        <tbody>
        @foreach($items as $i)
            <tr>
                <td>{{ $i->imgn_generic_name }}</td>
                <td>Initial: {{ $i->initial_quantity }} <br>
                    Added: {{ $i->in_quantity }} <br>
                    Total: {{ $i->initial_quantity+$i->in_quantity }}
                </td>
                <td>
                    Dispense: {{ $i->out_dispense }} <br>
                    Dispose: {{ $i->out_dispose }} <br>
                    Total: {{ $i->out_dispense+$i->out_dispose }}
                </td>
                <td>
                {{ ($i->initial_quantity+$i->in_quantity)-($i->out_dispense+$i->out_dispose) }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

</body>
</html>