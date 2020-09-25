<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $invoice->id }}</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style>
        h1,h2,h3,h4,p,span,div { font-family: DejaVu Sans; }
    </style>
</head>
<body>
<div style="clear:both; position:relative;">
    <div style="position:absolute; left:0pt; width:250pt;">
        <img class="img-rounded" height="65px" src="https://www.freeback.online/images/mail_logo.png">
    </div>
    <div style="margin-left:300pt;">
        <b>Data: </b> {{$invoice->created_at->format('d/m/20y')}}<br />
        <b>Fattura WEB_{{$invoice->invoice_number}}-{{$invoice->created_at->format('y')}}</b>
        <br />
    </div>
</div>
<br />
<h2>Fattura : WEB{{$invoice->invoice_number}}-{{$invoice->created_at->format('y')}}</h2>
<div style="clear:both; position:relative;">
    <div style="position:absolute; left:0pt; width:250pt;">
        <h4>Emessa Da:</h4>
        <div class="panel panel-default">
            <div class="panel-body">
                Bluerock Technologies Italia<br/>
                Via del Corso, 303 <br/>
                00185, Roma<br/>
                P.IVA : 14379871008 <br/>
                IBAN: IT04F0311103231000000000113
            </div>
        </div>
    </div>
    <div style="margin-left: 300pt;">
        <h4>All'Attenzione Di:</h4>
        <div class="panel panel-default">
            <div class="panel-body">
                {{$invoice->store->business_name}}<br/>
                {{$invoice->store->branches()->first()->street_address}} <br/>
                P.IVA {{$invoice->store->vat_number}} <br/>
            </div>
        </div>
    </div>
</div>
<h4>Articoli:</h4>
<table class="table table-bordered">
    <thead>
    <tr>
        <th>#</th>
        <th>Descrizione</th>
        <th>Data</th>
        <th>Vendita(€)</th>
        <th>% Sconto</th>
        <th>Importo (€)</th>
        <th>IVA (22%)</th>
        <th>Totale (€)</th>
    </tr>
    </thead>
    <tbody>

    @foreach($transactions as $key=>$transaction)
        <tr>
            <td>1</td>
            <td>Servizi di marketplace- Compensi per utilizzo della piattaforma Freeback</td>
            <td>{{$transaction->created_at->format('d/m/20y')}}</td>
            <td>{{number_format($transaction->full_import,2)}}</td>
            <td>{{number_format($transaction->discount_rate,2)}}%</td>
            <td>{{number_format($transaction->freeback_neto/1.22,2)}}</td>
            <td>{{number_format(($transaction->freeback_neto - $transaction->freeback_neto/1.22),2)}}</td>
            <td>{{number_format($transaction->freeback_neto,2)}}</td>
        </tr>

        <tr>
            <td>2</td>
            <td>Quota di Cashback al cliente per vendita su Marketplace</td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{number_format($transaction->cashback_neto/1.22,2)}}</td>
            <td>{{number_format(($transaction->cashback_neto - $transaction->cashback_neto/1.22),2)}}</td>
            <td>{{number_format($transaction->cashback_neto,2)}}</td>
        </tr>
    @endforeach
    <tr>
        <td></td>
        <td>Totali</td>
        <td></td>
        <td>{{number_format($sum,2)}}</td>
        <td></td>
        <td>{{number_format($clearSum,2)}}</td>
        <td>{{number_format($vatSum,2)}}</td>
        <td>{{number_format($totalSum,2)}}</td>
    </tr>

    </tbody>
</table>
<div style="clear:both; position:relative;">

    <div style="position:absolute; left:0pt; width:250pt;">
        <h4>Note:</h4>
        <div class="panel panel-default">
            <div class="panel-body">
                Questa fattura è già stata pagata.
            </div>
        </div>
    </div>

    <div style="margin-left: 300pt;">
        <h4>Totale Documento:</h4>
        <table class="table table-bordered">
            <tbody>
            <tr>
                <td><b>Totale</b></td>
                <td><b>{{number_format($totalSum,2)}}</b> Euro</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<br /><br />

</body>
</html>

