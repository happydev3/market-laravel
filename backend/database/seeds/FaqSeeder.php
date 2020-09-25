<?php

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faq =  new Faq();
        $faq->question = "Per effettuare un acquisto devo essere registrato?";
        $faq->answer = "Si, per effettuare un acquisto devi registrarti. Potrai seguire l'arrivo del tuo ordine dalla tua area personale, gestire i tuoi acquisti e richiedere assistenza dopo la vendita qualora necessario. Se non lo hai ancora fatto, puoi registrarti cliccando sull\'apposito link.";
        $faq->save();

        $faq =  new Faq();
        $faq->question = "Come faccio a effettuare un acquisto?";
        $faq->answer = "Fare un ordine online è facilissimo:
1 - Cerca il prodotto che desideri con la ricerca o navigando tra i negozi
2 - Scegli quello che fa per te e aggiungilo al carrello
3 - compila i tuoi dati e conferma l'ordine.
Riceverai una email di conferma con i dati del tuo ordine e i prossimi passi. Potrai seguire la consegna dalla tua area personale e riceverai tutti gli aggiornamenti via email e telefono";
        $faq->save();

        $faq =  new Faq();
        $faq->question = "Come faccio a sapere se il mio ordine è stato inserito correttamente?";
        $faq->answer = "Il tuo nuovo ordine appare subito nella tua area personale nella sezione \"i Tuoi Ordini\", in cui trovi tutti i dati e info sulla consegna
Ti inviamo inoltre un'email di conferma con tutti i dati dell'ordine. Se non la ricevi controlla nella posta indesiderata.
Se nella tua area personale non è presente il nuovo ordine e non hai ricevuto l'email di conferma, è probabile che l'ordine non sia stato correttamente inserito.
";
        $faq->save();

        $faq =  new Faq();
        $faq->question = "I prezzi sono comprensivi di IVA?";
        $faq->answer = "Tutti i prezzi sono da intendersi come prezzi al pubblico e, quindi, comprensivi di IVA ";
        $faq->save();

        $faq =  new Faq();
        $faq->question = "Posso avere la fattura intestata all’azienda?";
        $faq->answer = "Certo, quando nel carrello ti vengono richiesti i dati di fatturazione, puoi scegliere se intestare la fattura a una persona fisica o a un'azienda (o libero professionista con partita IVA). Se hai già effettuato l'ordine ma non è ancora stato spedito puoi richiedere al nostro servizio clienti la modifica dei dati. Ricorda che se acquisti come azienda o libero professionista, non potrai avvalerti del Diritto di Recesso.";
        $faq->save();

        $faq =  new Faq();
        $faq->question = "Cos’è il Marketplace?";
        $faq->answer = "Il Marketplace è un servizio che permette ai migliori brand e venditori professionali di vendere i propri prodotti sul sito Freeback. Nel dettaglio del prodotto che hai scelto è sempre indicato se il prodotto è venduto direttamente da Freeback o da un venditore del marketplace.";
        $faq->save();

        $faq =  new Faq();
        $faq->question = "È possibile acquistare più prodotti da un solo venditore?";
        $faq->answer = "Sì. Scegli comodamente tutti i prodotti che desideri acquistare. Le spese non sono una semplice somma matematica, ma un calcolo ponderato che considera le quantità e il peso/volume dei prodotti scelti. Potrai vedere il costo di spedizione applicato all’ordine nel carrello, prima di confermare l’acquisto.";
        $faq->save();


        $faq =  new Faq();
        $faq->question = "È possibile acquistare contemporaneamente prodotti da più venditori?";
        $faq->answer = "Sì, puoi creare dei carrelli misti, mediante un unico pagamento. Tieni presente che le spedizioni saranno poi effettuate, gestite e addebitate sulla tua carta di pagamento come ordini indipendenti dei diversi venditori, con date di consegna differenti ";
        $faq->save();


        $faq =  new Faq();
        $faq->question = "Freeback è responsabile del comportamento dei venditori del Marketplace?";
        $faq->answer = "Freeback non è direttamente responsabile del comportamento dei venditori del Marketplace, ma il contratto stipulato in fase di iscrizione contiene obblighi e diritti, che tutelano in ogni momento il consumatore finale. Qualora insorgessero difficoltà tra venditori e acquirenti, Freeback ha messo a punto un Programma di Protezione Clienti, che si applica a tutti i casi in cui gli acquirenti possono avere difficoltà con i venditori, come la mancata consegna, i prodotti difettosi o non conformi alla descrizione o i mancati rimborsi.
Tale programma si attiva automaticamente nel momento in cui l’acquirente invia un reclamo a fronte di un reso/rimborso non eseguito.
";
        $faq->save();


        $faq =  new Faq();
        $faq->question = "Posso lasciare un feedback sul venditore?";
        $faq->answer = "Una volta ricevuto il tuo ordine, se vuoi, puoi lasciare la tua valutazione sul venditore da cui hai acquistato il prodotto.  ";
        $faq->save();


        $faq =  new Faq();
        $faq->question = "Quanto costa la consegna?";
        $faq->answer = "I prezzi dipendono dal tipo di consegna scelta, dal peso/volume dei prodotti acquistati, dal luogo di consegna e dipendono dalle politiche di vendita dei venditori. Per ciascun prodotto potrai conoscere i costi della consegna aggiungendolo al carrello dopo aver compilato i dati di fatturazione e spedizione, prima della conferma dell'ordine.";
        $faq->save();


        $faq =  new Faq();
        $faq->question = "Come posso tracciare la spedizione del mio ordine?";
        $faq->answer = "Puoi tracciare la spedizione del tuo ordine andando nel dettaglio dell’ordine cliccando su \"Traccia Dettaglio Spedizione\"  ";
        $faq->save();


        $faq =  new Faq();
        $faq->question = "Le transazioni con carta di credito sono sicure?";
        $faq->answer = "Sì, i pagamenti effettuati con Carta di Credito sul nostro sito sono criptati e dunque sicuri.
Per salvaguardare la tua privacy e la sicurezza, infatti, quando ti registri ed inserisci la tua carta di credito o quando procedi al pagamento con carta di credito, viene utilizzato un sistema di pagamento sicuro, garantito dal certificato VeriSign. I dati della tua carta di credito vengono trasmessi, tramite una connessione protetta in crittografia SSL (Secure Socket Layer), direttamente a Banca Sella, per l'autorizzazione e l'addebito. Questo vuol dire che non siamo in grado, in nessun momento della procedura di acquisto e in nessun caso, di conoscere informazioni personali relative al titolare né il numero della carta. A noi giungerà soltanto l'autorizzazione fornita dal gestore della carta.
";
        $faq->save();


        $faq =  new Faq();
        $faq->question = "Perché è stata rifiutata la mia carta di credito?";
        $faq->answer = "Può accadere che la tua carta di credito non venga accettata per questi motivi:
È possibile che tu abbia oltrepassato il limite di credito. La tua banca può darti tutte le informazioni necessarie sulla tua carta e sulle possibilità di pagamento.
I dati richiesti per il pagamento non coincidono con quelli tua carta. Un semplice errore tipografico in uno dei campi, può causare il rifiuto dell'operazione.
La tua carta di credito è scaduta, controlla la data di scadenza, la trovi sulla carta stessa.
";
        $faq->save();

        $faq =  new Faq();
        $faq->question = "
Quando sarà effettuato l’addebito sulla mia Carta di Credito?";
        $faq->answer = "L'importo relativo all'acquisto effettuato verrà addebitato sulla tua carta di credito al momento della conferma dell'ordine. L'addebito sul tuo conto seguirà i tempi stabiliti dal gestore della carta. Contatta la tua banca per ulteriori informazioni.";
        $faq->save();


        $faq =  new Faq();
        $faq->question = "
Posso annullare un ordine il cui pagamento è stato effettuato con carta di credito?";
        $faq->answer = "Sì, se il tuo ordine non è ancora stato spedito puoi richiedere l'annullamento direttamente dal dettaglio dell'ordine nell'area personale del sito. In seguito alla conferma di annullamento, verrà automaticamente stornata la transazione direttamente sulla tua carta di credito.";
        $faq->save();

        $faq =  new Faq();
        $faq->question = "Ho cambiato idea su un prodotto. Posso restituirlo?";
        $faq->answer = "Se dovessi cambiare idea o sfortunatamente dovessero esserci dei problemi, puoi decidere di restituire il prodotto acquistato con le modalità specificate dal venditore.
La richiesta di recesso deve pervenire entro 14 giorni di calendario dalla ricezione dell'ordine e puoi inserirla direttamente dal dettaglio del tuo ordine, cliccando su Richiedi reso.
Il diritto di recesso si applica solo ai consumatori, ovvero persone fisiche che agiscono per scopi estranei all’attività imprenditoriale o professionale eventualmente svolta.
";
        $faq->save();


        $faq =  new Faq();
        $faq->question = "Ho acquistato con partita IVA e ho cambiato idea su un prodotto. Posso restituirlo?";
        $faq->answer = "Il Diritto di Recesso è regolato dal Codice del Consumo e riguarda solo le compravendite a distanza tra il venditore e i consumatori privati non professionali. Pertanto, se sei una partita IVA o un'azienda, non puoi avvalerti del diritto di recesso. Per maggiori informazioni, consulta la pagina del Diritto di recesso.";
        $faq->save();


        $faq =  new Faq();
        $faq->question = "Ho ricevuto un prodotto sbagliato";
        $faq->answer = "Scegli l'ordine per il quale hai riscontrato il problema e rivolgiti direttamente al venditore. Il nostro Servizio Clienti, in ogni caso, sarà sempre pronto ad aiutarti per qualsiasi problema. ";
        $faq->save();

        $faq =  new Faq();
        $faq->question = "Nel mio pacco manca un articolo. Cosa devo fare?";
        $faq->answer = "Scegli l'ordine per il quale hai riscontrato il problema e rivolgiti direttamente al venditore. Il nostro Servizio Clienti, in ogni caso, sarà sempre pronto ad aiutarti per qualsiasi problema";
        $faq->save();


        $faq =  new Faq();
        $faq->question = "Ho ricevuto un prodotto sbagliato. Cosa devo fare?";
        $faq->answer = "Scegli l'ordine per il quale hai riscontrato il problema, clicca su \"Articolo errato/danneggiato\".
Seleziona il prodotto per cui vuoi fare la segnalazione e segui la procedura guidata.  Il nostro Servizio Clienti ti risponderà al più presto.
";
        $faq->save();

        $faq =  new Faq();
        $faq->question = "Nel mio pacco manca un articolo. Cosa devo fare?";
        $faq->answer = "Scegli l'ordine per il quale hai riscontrato il problema, clicca su \"Articolo errato/danneggiato\". Seleziona il prodotto per cui vuoi fare la segnalazione e segui la procedura guidata.  Il nostro Servizio Clienti ti risponderà al più presto.";
        $faq->save();

        $faq =  new Faq();
        $faq->question = "Sto aspettando un rimborso sulla mia carta di credito, quanto tempo ci vuole?";
        $faq->answer = "Per rimborsi effettuati su carta di credito, le tempistiche di riaccredito dell'importo sono dipendenti dal circuito emittente della carta, indicativamente 5-10 giorni lavorativi da quando riceverai la comunicazione che conferma lo storno. Per informazioni più precise ti consigliamo di contattare l'assistenza clienti della tua carta di credito.
Nel caso tu abbia effettuato un reso, il rimborso viene effettuato solo ad avvenuta ricezione e verifica dei prodotti resi presso il nostro magazzino.";
        $faq->save();

        $faq =  new Faq();
        $faq->question = "Ho cambiato idea su un prodotto, posso restituirlo?";
        $faq->answer = "Certo, se dovessi cambiare idea puoi esercitare il diritto di recesso, informando direttamente il venditore entro 14 giorni dalla consegna della merce, puoi inserire la richiesta direttamente dal dettaglio del tuo ordine, cliccando su Richiedi reso.  
Il diritto di recesso si applica solo ai consumatori, ovvero persone fisiche che agiscono per scopi estranei all’attività imprenditoriale o professionale eventualmente svolta. Per maggiori informazioni, consulta la pagina del Diritto di Reccesso.
";
        $faq->save();

        $faq =  new Faq();
        $faq->question = "Come posso esercitare il diritto di recesso?";
        $faq->answer = "Per esercitare il diritto di recesso, sei tenuto a informare il venditore della tua decisione entro 14 giorni dalla consegna della merce tramite la funzione Richiedi reso, disponibile nella pagina di dettaglio ordine nella tua Area Personale, scegliendo come motivazione Diritto di recesso.
Se necessario sarai contattato dal venditore per informazioni aggiuntive e indicazioni sul rimborso.
Ti suggeriamo di contattare sempre il venditore per ogni dubbio o domanda in merito.
";
        $faq->save();

        $faq =  new Faq();
        $faq->question = "L’oggetto che ho acquistato risulta danneggiato/difettoso/non conforme.";
        $faq->answer = "Se l’oggetto da te acquistato dovesse risultare danneggiato, difettoso, non conforme o comunque non rispondente alle tue aspettative, puoi contattare il venditore che eventualmente provvederà a sostituirlo. Accedi alla pagina di  dettaglio dell’ordine nella tua area personale e utilizza la funzione Richiedi reso, indicando la motivazione per cui stai inviando la richiesta. Sarai contattato dal venditore per informazioni aggiuntive o indicazioni sul reso. In alternativa puoi esercitare il diritto di recesso comunicandolo al venditore entro 14 giorni da quando i prodotti ti vengono consegnati.";
        $faq->save();

        $faq =  new Faq();
        $faq->question = "Ho inviato una richiesta di reso al venditore ma non mi ha risposto.";
        $faq->answer = "Se hai inviato la richiesta al venditore utilizzando l’apposita funzione Richiedi reso nel dettaglio prodotto e il venditore non ti risponde entro 7 giorni, puoi segnalarlo a Freeback attivando la funzione Invia reclamo. Potrai mandare un messaggio al nostro Servizio Clienti che interverrà per approfondire il problema. ";
        $faq->save();

        $faq =  new Faq();
        $faq->question = "Non ho ricevuto il mio ordine e il venditore non mi ha rimborsato.";
        $faq->answer = "Qualora non ricevessi il prodotto che hai ordinato, puoi accedere alla scheda dell’ordine per sapere se l’ordine è stato spedito e quando è prevista la consegna. In caso di mancata consegna puoi cliccare sul tasto Richiedi reso, con il quale puoi segnalare al venditore la non avvenuta consegna dell’ordine e la richiesta di rimborso.
In caso di mancato riscontro dal venditore entro 7 giorni, puoi segnalarlo a Freeback utilizzando la funzione Invia reclamo presente nel dettaglio ordine.
Ricorda che per inviare un reclamo a Freeback, devi aver effettivamente inoltrato la richiesta di reso/rimborso al venditore, e tale richiesta dev’essere rimasta inevasa.";
        $faq->save();

        $faq =  new Faq();
        $faq->question = "L'ordine è spedito data di consegna ma prevista è passata, cosa posso fare?";
        $faq->answer = "Se la data di prevista consegna è passata ed il prodotto non è stato consegnato puoi consultare il tracking della spedizione accedendo al dettaglio ordine.Ti invitiamo ad attendere 1/2 giorni lavorativi prima di contattarci, perchè può accadere che il corriere abbia un piccolo ritardo. Nel caso in cui dovessero verificarsi ritardi maggiori, ti invitiamo a contattarci per verificare lo stato della spedizione. Puoi scriverci direttamente dal dettaglio ordine, accedi ai tuoi ordini utilizzando il pulsante Scrivi al servizio clienti";
        $faq->save();

        $faq =  new Faq();
        $faq->question = "Mi sono dimenticato la password come posso recuperarla?";
        $faq->answer = "Se hai dimenticato la tua password puoi cliccare su \"Password Dimenticata\". Ti sarà spedita un’e-mail per il recupero delle tue credenziali.Se non hai ricevuto l’email di recupero della password ti consigliamo di controllare nelle cartelle di posta indesiderata del tuo programma di posta elettronica.";
        $faq->save();

        $faq =  new Faq();
        $faq->question = "Posso modificare l'email con la quale accedo all'area personale?";
        $faq->answer = "Per modificarla accedi alla tua area personale, nella sezione \"Impostazioni Account\". Lì potrai indicare la tua nuova email.
La nuova email dovrà essere valida e in uso, pertanto ti manderemo un'email con un link da cliccare come conferma.
";
        $faq->save();

        $faq =  new Faq();
        $faq->question = "Gli sconti hanno una scadenza?";
        $faq->answer = "No. Gli sconti sono decisi dai venditori e sono riservati agli Utenti di Freeback; possono variare nel tempo a seconda delle scelte commerciali dei Venditori. Controlla sempre la lo sconto riservato dal venditore per gli articoli che voi acquistare su Freeback.";
        $faq->save();

        $faq =  new Faq();
        $faq->question = "
Gli sconti sono convertibili in denaro?";
        $faq->answer = "Si sempre !.  Gli sconti riservati dai Venditori agli Utenti di Freeback sono sempre denaro che Freeback ti metterà a disposizione sulla tua carta di debito/ credito che hai indicato al momento della tua iscrizione a Freeback.";
        $faq->save();

        $faq =  new Faq();
        $faq->question = "Come ottengo il mio rimborso degli sconti maturati";
        $faq->answer = "Per ogni acquisto che hai effettuato tramite Freeback, hai diritto a un rimborso pari a una percentuale della spesa fatta (sconto). Questa percentuale varia a seconda del negozio ed è indicata accanto al suo nome. Il rimborso ti è accreditato sul portafoglio di Freeback quando il negozio conferma il tuo avvenuto pagamento.
Attenzione: Se acquisti qualcosa dimenticando di utilizzare Freeback come punto di partenza o senza effettuare l’accesso, la tua spesa non potrà essere registrata e non avrai diritto ad alcun rimborso.
Compra dove vuoi e quello che vuoi ma ricordati sempre di passare da Freeback per assicurarti il tuo sconto.";
        $faq->save();

        $faq =  new Faq();
        $faq->question = "Come viene calcolata la percentuale di ogni negozio per il rimborso";
        $faq->answer = "Vorremmo offrirti il rimborso più alto possibile e lavoriamo costantemente a questo scopo ma è il Venditore a decidere quale sia la percentuale di sconto per gli utenti di Freeback.";
        $faq->save();

        $faq =  new Faq();
        $faq->question = "Quando vengo pagato?";
        $faq->answer = "Per poter incassare i tuoi rimborsi, l’unica condizione richiesta da Freeback è quella di accumulare un totale di almeno 10 Euro nel tuo salvadanaio. Raggiunta questa cifra ti basta accedere al tuo profilo e fare un click su “Incassa”. Ti verrà effettuato un bonifico sulla carta ricaricabile da te indicata all’atto dell’iscrizione detratti 0,50€ di costi di bancari per il Bonifico. Se si tratta del primo bonifico di rimborso ti verrà detratta la quota di iscrizione di Freeback pari a 6 euro annuali.";
        $faq->save();

        $faq =  new Faq();
        $faq->question = "Mi è stato annullato un rimborso perche?";
        $faq->answer = "Se il negozio dove hai acquistato annulla il tuo pagamento (ad esempio per un reso) il tuo rimborso sarà cancellato di conseguenza. Se ritieni che sia stato annullato per sbaglio un rimborso a cui pensi di avere diritto, accedi al tuo profilo e apri una segnalazione in merito. Freeback si occuperà di risolvere il tuo problema.";
        $faq->save();

        $faq =  new Faq();
        $faq->question = "Quando incasso il rimborso è soggetto a tassazione?";
        $faq->answer = "No. Il rimborso dei tuoi acquisti diretti non è soggetto ad alcuna tassazione e non viene praticata alcuna ritenuta.
I guadagni generati dal programma \"Invita un Amico\" sono soggetti a ritenuta d’acconto come descritto nel contratto di abbonamento a Freeback";
        $faq->save();











    }
}
