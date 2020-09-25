<?php

namespace App\Http\Controllers\Admin;

use App\Models\CashInvoice;
use App\Models\CashTransaction;
use PDF;
use App\Http\Controllers\Controller;
use Spatie\ArrayToXml\ArrayToXml;

class CashInvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        return view('admin.cash_invoices')->with('invoiceSum',CashInvoice::where('valid',1)->sum('total'));
    }

    public function getCashInvoices(){
        $invoices = CashInvoice::where('valid',1)->with(array('store'=>function($query){
            $query->select('id','business_name');
        }))->get();
        return $invoices;
    }

    public function markAsSent($id){
        $invoice = CashInvoice::where('id',$id)->firstOrFail();
        $invoice->sent = 1;
        $invoice->save();
        return redirect()->back();
    }

    public function downloadInvoice($id){
        $data['invoice'] = CashInvoice::where('id',$id)->firstOrFail();
        $data['transactions'] = CashTransaction::where('cash_invoice_id',$data['invoice']->id)->where('status','accepted')->get();
        $data['sum'] = 0;
        $data['clearSum'] = 0;
        $data['vatSum'] = 0;
        $data['totalSum'] = 0;


        foreach($data['transactions'] as $t) {
            $data['sum'] += $t->full_import;
            $data['clearSum'] += ($t->cashback_neto/1.22) + ($t->freeback_neto/1.22);
            $data['vatSum'] += (($t->freeback_neto - $t->freeback_neto/1.22) + ($t->cashback_neto - $t->cashback_neto/1.22));
            $data['totalSum'] += $t->freeback_neto + $t->cashback_neto;
        }


        $pdf = PDF::loadView('invoices.cash_invoice',$data);
        return $pdf->download("Fattura_Cash_".$data['invoice']->invoice_number.".pdf");
    }


    public function downloadXML($id){
        $invoice = CashInvoice::where('id',$id)->firstOrFail();
        $invoiceTransactions = $invoice->cashTransactions()->get();

        $linee = [];

        foreach($invoiceTransactions as $key=>$t) {
           $linea = [
                'NumeroLinea' => $key,
                'Descrizione' => 'Prestazione Marketplace...',
                'Quantita' => 1,
                'PrezzoUnitario' => $t->cashback_neto + $t->freeback_neto,
                'PrezzoTotale' => $t->cashback_neto + $t->freeback_neto,
                'AliquotaIVA' => 22,
            ];

           array_push($linea,$linea);
        }

        header("Content-type: text/xml");
        header("Cache-Control: no-store, no-cache");
        header('Content-Disposition: attachment; filename="invoice.xml"');

        $file = fopen('php://output','w');


        $xml = [
            'FatturaElettronicaHeader' => [
                'DatiTrasmissione' => [
                    'IdTrasmissione' => [
                        'IdPaese' => 'IT',
                        'IdCodice' => '0123456',
                    ],
                    'ProgressivoInvio' => $invoice->invoice_number,
                    'FormatoTrasmissione' => "FPA12",
                    'CodiceDestinatario' => $invoice->store->ae_code,
                ],
                'CedentePrestatore' => [
                    'DatiAnagrafici' => [
                        'IdFiscaleIva' => [
                            'idPaese' => "IT",
                            'idCodice' => "14379871008"
                        ],
                        'Anagrafica' => [
                            'Denominazione' => 'Bluerock Technologies Italia',
                        ],
                        'RegimeFiscale' => "RF01",
                    ],
                    'Sede' => [
                        'Indirizzo' => 'Via del Corso, 303',
                        'CAP' => '00185',
                        'Comune' => "Roma",
                        'Provincia' => 'RM',
                        'Nazione' => 'IT',
                    ],
                ],
                'CessionarioCommitente' => [
                    'DatiAnagrafici' => [
                        'CodiceFiscale' => $invoice->store->vat_number,
                        'Anagrafica' => [
                            'Denominazione' => $invoice->store->business_name,
                        ],
                        'Sede' => [
                            'Indirizzo' => 'Via di Roma 22',
                            'CAP' => '48122',
                            'Comune' => "RAVENNA",
                            'Provincia' => 'RA',
                            'Nazione' => 'IT',
                        ]

                    ]
                ]
            ],
            'FatturaElettronicaBody' => [
                'DatiGenerali' => [
                    'DatiGeneraliDocumento' => [
                        'TipoDocumento' => 'Fattura',
                        'Divisa' => 'EUR',
                        'Data' => $invoice->created_at->format('20y-m-d'),
                        'Numero' => $invoice->invoice_number,
                        'Casuale' => 'Fattura di servizi di Marketplace Freeback.com',
                    ],
                ],
                'DatiBeniServizi' => [
                    'DettaglioLinee' => [$linee],
                ],
            ],
        ];

        $result = ArrayToXml::convert($xml,[
            'rootElementName' => 'p:FatturaElettronica',
            '_attributes' => [
                'xmlns:ds' => 'http://www.w3.org/2000/09/xmldsig#',
                'xmlns:p' => 'http://ivaservizi.agenziaentrate.gov.it/docs/xsd/fatture/v1.2',
                'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
                'versione' => 'FPA12',
                'xsi:schemaLocation' => 'http://ivaservizi.agenziaentrate.gov.it/docs/xsd/fatture/v1.2 http://www.fatturapa.gov.it/export/fatturazione/sdi/fatturapa/v1.2/Schema_del_file_xml_FatturaPA_versione_1.2.xsd',
            ]

        ]);

        fwrite($file,$result);

        return;
    }


    public function markAsPaid($id){
        $invoice =  CashInvoice::where('id',$id)->firstOrFail();
        $invoice->paid = 1;
        $invoice->save();
        return redirect()->back();
    }
}
