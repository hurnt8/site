@php
$texts = [
    'fr' => [
        'title'      => 'Demande de prêt reçue',
        'sub'        => site_name(),
        'greeting'   => 'Bonjour '.$data['name'].',',
        'body'       => 'Nous avons bien reçu votre demande de prêt d\'un montant de <strong>'.number_format($data['amount'], 0, ',', ' ').' '.($data['currency'] ?? 'EUR').'</strong> sur <strong>'.$data['darly'].' mois</strong>. Elle est actuellement en cours de traitement par notre équipe.',
        'cond_title' => 'Conditions d\'éligibilité',
        'cond_body'  => 'Pour obtenir un prêt, il faut avoir au moins 18 ans, percevoir un revenu mensuel stable et pouvoir rembourser selon les conditions fixées.',
        'footer'     => 'Nous vous contacterons dans les plus brefs délais. Merci de nous avoir fait confiance.',
        'noreply'    => 'Cet email a été envoyé depuis une adresse no-reply. Veuillez ne pas répondre directement.',
        'closing'    => 'Cordialement,',
        'team'       => 'L\'équipe ' . site_name(),
    ],
    'en' => [
        'title'      => 'Loan application received',
        'sub'        => site_name(),
        'greeting'   => 'Hello '.$data['name'].',',
        'body'       => 'We have received your loan request for <strong>'.number_format($data['amount'], 0, ',', ' ').' '.($data['currency'] ?? 'EUR').'</strong> over <strong>'.$data['darly'].' months</strong>. It is currently being processed by our team.',
        'cond_title' => 'Eligibility conditions',
        'cond_body'  => 'To obtain a loan, you must be at least 18 years old, have a stable monthly income, and be able to repay according to the set conditions.',
        'footer'     => 'We will contact you as soon as possible. Thank you for trusting us.',
        'noreply'    => 'This email was sent from a no-reply address. Please do not reply directly.',
        'closing'    => 'Best regards,',
        'team'       => 'The ' . site_name() . ' team',
    ],
    'es' => [
        'title'      => 'Solicitud de préstamo recibida',
        'sub'        => site_name(),
        'greeting'   => 'Hola '.$data['name'].',',
        'body'       => 'Hemos recibido su solicitud de préstamo por <strong>'.number_format($data['amount'], 0, ',', ' ').' '.($data['currency'] ?? 'EUR').'</strong> a <strong>'.$data['darly'].' meses</strong>. Actualmente está siendo procesada por nuestro equipo.',
        'cond_title' => 'Condiciones de elegibilidad',
        'cond_body'  => 'Para obtener un préstamo, debe tener al menos 18 años, percibir ingresos mensuales estables y poder reembolsar según las condiciones establecidas.',
        'footer'     => 'Nos pondremos en contacto con usted lo antes posible. Gracias por su confianza.',
        'noreply'    => 'Este email fue enviado desde una dirección de no respuesta. No responda directamente.',
        'closing'    => 'Atentamente,',
        'team'       => 'El equipo ' . site_name(),
    ],
    'pl' => [
        'title'      => 'Wniosek o pożyczkę otrzymany',
        'sub'        => site_name(),
        'greeting'   => 'Witaj '.$data['name'].',',
        'body'       => 'Otrzymaliśmy Twój wniosek o pożyczkę na kwotę <strong>'.number_format($data['amount'], 0, ',', ' ').' '.($data['currency'] ?? 'EUR').'</strong> na <strong>'.$data['darly'].' miesięcy</strong>. Jest on aktualnie przetwarzany przez nasz zespół.',
        'cond_title' => 'Warunki kwalifikowalności',
        'cond_body'  => 'Aby uzyskać pożyczkę, należy mieć co najmniej 18 lat, osiągać stałe miesięczne dochody i móc spłacać zgodnie z ustalonymi warunkami.',
        'footer'     => 'Skontaktujemy się z Tobą jak najszybciej. Dziękujemy za zaufanie.',
        'noreply'    => 'Ten email został wysłany z adresu no-reply. Prosimy nie odpowiadać bezpośrednio.',
        'closing'    => 'Z poważaniem,',
        'team'       => 'Zespół ' . site_name(),
    ],
    'bg' => [
        'title'      => 'Заявка за заем получена',
        'sub'        => site_name(),
        'greeting'   => 'Здравейте '.$data['name'].',',
        'body'       => 'Получихме вашата заявка за заем в размер на <strong>'.number_format($data['amount'], 0, ',', ' ').' '.($data['currency'] ?? 'EUR').'</strong> за срок от <strong>'.$data['darly'].' месеца</strong>. В момента тя се обработва от нашия екип.',
        'cond_title' => 'Условия за допустимост',
        'cond_body'  => 'За да получите заем, трябва да сте на поне 18 години, да получавате стабилен месечен доход и да можете да изплащате според определените условия.',
        'footer'     => 'Ще се свържем с вас възможно най-скоро. Благодарим ви за доверието.',
        'noreply'    => 'Този имейл беше изпратен от адрес без отговор (no-reply). Моля, не отговаряйте директно.',
        'closing'    => 'С уважение,',
        'team'       => 'Екипът на ' . site_name(),
    ],
    'hu' => [
        'title'      => 'Kölcsönkérelem beérkezett',
        'sub'        => site_name(),
        'greeting'   => 'Üdvözöljük '.$data['name'].',',
        'body'       => 'Megkaptuk <strong>'.number_format($data['amount'], 0, ',', ' ').' '.($data['currency'] ?? 'EUR').'</strong> összegű, <strong>'.$data['darly'].' hónapos</strong> futamidejű kölcsönkérelmét. Jelenleg csapatunk dolgozza fel.',
        'cond_title' => 'Jogosultsági feltételek',
        'cond_body'  => 'Kölcsön igényléséhez legalább 18 évesnek kell lennie, stabil havi jövedelemmel kell rendelkeznie, és képesnek kell lennie a meghatározott feltételek szerinti törlesztésre.',
        'footer'     => 'A lehető leghamarabb felvesszük Önnel a kapcsolatot. Köszönjük bizalmát.',
        'noreply'    => 'Ezt az e-mailt egy no-reply címről küldtük. Kérjük, ne válaszoljon közvetlenül.',
        'closing'    => 'Tisztelettel,',
        'team'       => 'A ' . site_name() . ' csapata',
    ],
    'it' => [
        'title'      => 'Richiesta di prestito ricevuta',
        'sub'        => site_name(),
        'greeting'   => 'Ciao '.$data['name'].',',
        'body'       => 'Abbiamo ricevuto la tua richiesta di prestito di <strong>'.number_format($data['amount'], 0, ',', ' ').' '.($data['currency'] ?? 'EUR').'</strong> su <strong>'.$data['darly'].' mesi</strong>. È attualmente in fase di elaborazione da parte del nostro team.',
        'cond_title' => 'Condizioni di ammissibilità',
        'cond_body'  => 'Per ottenere un prestito, è necessario avere almeno 18 anni, percepire un reddito mensile stabile e poter rimborsare secondo le condizioni stabilite.',
        'footer'     => 'Ti contatteremo il prima possibile. Grazie per la fiducia accordataci.',
        'noreply'    => 'Questa email è stata inviata da un indirizzo no-reply. Ti preghiamo di non rispondere direttamente.',
        'closing'    => 'Cordiali saluti,',
        'team'       => 'Il team ' . site_name(),
    ],
    'de' => [
        'title'      => 'Kreditanfrage eingegangen',
        'sub'        => site_name(),
        'greeting'   => 'Guten Tag '.$data['name'].',',
        'body'       => 'Wir haben Ihre Kreditanfrage über <strong>'.number_format($data['amount'], 0, ',', ' ').' '.($data['currency'] ?? 'EUR').'</strong> für eine Laufzeit von <strong>'.$data['darly'].' Monaten</strong> erhalten. Sie wird derzeit von unserem Team bearbeitet.',
        'cond_title' => 'Voraussetzungen',
        'cond_body'  => 'Um einen Kredit zu erhalten, müssen Sie mindestens 18 Jahre alt sein, über ein stabiles monatliches Einkommen verfügen und in der Lage sein, gemäß den festgelegten Bedingungen zurückzuzahlen.',
        'footer'     => 'Wir werden uns so schnell wie möglich bei Ihnen melden. Vielen Dank für Ihr Vertrauen.',
        'noreply'    => 'Diese E-Mail wurde von einer no-reply-Adresse gesendet. Bitte antworten Sie nicht direkt auf diese Nachricht.',
        'closing'    => 'Mit freundlichen Grüßen,',
        'team'       => 'Das ' . site_name() . '-Team',
    ],
    'lt' => [
        'title'      => 'Paskolos paraiška gauta',
        'sub'        => site_name(),
        'greeting'   => 'Sveiki, '.$data['name'].',',
        'body'       => 'Gavome jūsų paskolos paraišką <strong>'.number_format($data['amount'], 0, ',', ' ').' '.($data['currency'] ?? 'EUR').'</strong> sumai <strong>'.$data['darly'].' mėnesių</strong> laikotarpiui. Šiuo metu ją nagrinėja mūsų komanda.',
        'cond_title' => 'Reikalavimai',
        'cond_body'  => 'Norint gauti paskolą, būtina būti bent 18 metų amžiaus, turėti stabilias mėnesines pajamas ir galėti grąžinti paskolą pagal nustatytas sąlygas.',
        'footer'     => 'Susisieksime su jumis kuo greičiau. Dėkojame, kad pasitikite mumis.',
        'noreply'    => 'Šis el. laiškas išsiųstas iš no-reply adreso. Prašome tiesiogiai neatsakyti į šį pranešimą.',
        'closing'    => 'Pagarbiai,',
        'team'       => site_name() . ' komanda',
    ],
    'ro' => [
        'title'      => 'Cerere de împrumut primită',
        'sub'        => site_name(),
        'greeting'   => 'Bună ziua, '.$data['name'].',',
        'body'       => 'Am primit cererea dumneavoastră de împrumut în valoare de <strong>'.number_format($data['amount'], 0, ',', ' ').' '.($data['currency'] ?? 'EUR').'</strong> pe o perioadă de <strong>'.$data['darly'].' luni</strong>. Aceasta este în prezent în curs de procesare de către echipa noastră.',
        'cond_title' => 'Condiții de eligibilitate',
        'cond_body'  => 'Pentru a obține un împrumut, trebuie să aveți cel puțin 18 ani, să realizați un venit lunar stabil și să puteți rambursa conform condițiilor stabilite.',
        'footer'     => 'Vă vom contacta în cel mai scurt timp. Vă mulțumim pentru încrederea acordată.',
        'noreply'    => 'Acest e-mail a fost trimis de la o adresă no-reply. Vă rugăm să nu răspundeți direct la acest mesaj.',
        'closing'    => 'Cu stimă,',
        'team'       => 'Echipa ' . site_name(),
    ],
    'lv' => [
        'title'      => 'Aizdevuma pieteikums saņemts',
        'sub'        => site_name(),
        'greeting'   => 'Sveiki, '.$data['name'].',',
        'body'       => 'Mēs esam saņēmuši jūsu aizdevuma pieteikumu par summu <strong>'.number_format($data['amount'], 0, ',', ' ').' '.($data['currency'] ?? 'EUR').'</strong> uz <strong>'.$data['darly'].' mēnešiem</strong>. To pašlaik izskata mūsu komanda.',
        'cond_title' => 'Atbilstības nosacījumi',
        'cond_body'  => 'Lai saņemtu aizdevumu, jums jābūt vismaz 18 gadus vecam, jāsaņem stabili ikmēneša ienākumi un jāspēj atmaksāt aizdevumu saskaņā ar noteiktajiem nosacījumiem.',
        'footer'     => 'Mēs ar jums sazināsimies pēc iespējas ātrāk. Paldies par uzticēšanos.',
        'noreply'    => 'Šis e-pasts ir nosūtīts no adreses, uz kuru netiek pieņemtas atbildes. Lūdzu, neatbildiet tieši uz šo ziņojumu.',
        'closing'    => 'Ar cieņu,',
        'team'       => site_name() . ' komanda',
    ],
    'nl' => [
        'title'      => 'Leningaanvraag ontvangen',
        'sub'        => site_name(),
        'greeting'   => 'Hallo '.$data['name'].',',
        'body'       => 'Wij hebben uw leningaanvraag van <strong>'.number_format($data['amount'], 0, ',', ' ').' '.($data['currency'] ?? 'EUR').'</strong> over <strong>'.$data['darly'].' maanden</strong> in goede orde ontvangen. Deze wordt momenteel door ons team verwerkt.',
        'cond_title' => 'Toelatingsvoorwaarden',
        'cond_body'  => 'Om een lening te verkrijgen, moet u minstens 18 jaar oud zijn, over een stabiel maandinkomen beschikken en in staat zijn terug te betalen volgens de vastgestelde voorwaarden.',
        'footer'     => 'Wij nemen zo spoedig mogelijk contact met u op. Bedankt voor uw vertrouwen.',
        'noreply'    => 'Deze e-mail is verzonden vanaf een no-reply-adres. Gelieve niet rechtstreeks te antwoorden.',
        'closing'    => 'Met vriendelijke groet,',
        'team'       => 'Het ' . site_name() . ' Team',
    ],
    'pt' => [
        'title'      => 'Pedido de empréstimo recebido',
        'sub'        => site_name(),
        'greeting'   => 'Olá '.$data['name'].',',
        'body'       => 'Recebemos o seu pedido de empréstimo no montante de <strong>'.number_format($data['amount'], 0, ',', ' ').' '.($data['currency'] ?? 'EUR').'</strong> em <strong>'.$data['darly'].' meses</strong>. Está atualmente a ser processado pela nossa equipa.',
        'cond_title' => 'Condições de elegibilidade',
        'cond_body'  => 'Para obter um empréstimo, é necessário ter pelo menos 18 anos, auferir um rendimento mensal estável e poder reembolsar de acordo com as condições estabelecidas.',
        'footer'     => 'Entraremos em contacto consigo o mais brevemente possível. Obrigado pela sua confiança.',
        'noreply'    => 'Este email foi enviado a partir de um endereço no-reply. Não responda diretamente.',
        'closing'    => 'Atenciosamente,',
        'team'       => 'A equipa ' . site_name(),
    ],
    'hr' => [
        'title'      => 'Zahtjev za kredit primljen',
        'sub'        => site_name(),
        'greeting'   => 'Pozdrav '.$data['name'].',',
        'body'       => 'Zaprimili smo vaš zahtjev za kredit u iznosu od <strong>'.number_format($data['amount'], 0, ',', ' ').' '.($data['currency'] ?? 'EUR').'</strong> na <strong>'.$data['darly'].' mjeseci</strong>. Trenutno ga obrađuje naš tim.',
        'cond_title' => 'Uvjeti prihvatljivosti',
        'cond_body'  => 'Za dobivanje kredita potrebno je imati najmanje 18 godina, stabilan mjesečni prihod i mogućnost otplate prema utvrđenim uvjetima.',
        'footer'     => 'Kontaktirat ćemo vas u najkraćem mogućem roku. Hvala vam na povjerenju.',
        'noreply'    => 'Ova e-poruka poslana je s adrese na koju se ne odgovara (no-reply). Molimo ne odgovarajte izravno.',
        'closing'    => 'S poštovanjem,',
        'team'       => 'Tim ' . site_name(),
    ],
];
$t = $texts[$lang] ?? $texts['fr'];
$L = [
    'fr' => ['recap' => 'Récapitulatif de votre demande', 'amount' => 'Montant demandé', 'duration' => 'Durée', 'months' => 'mois', 'type' => 'Type de prêt', 'monthly' => 'Mensualité estimée', 'rate' => 'Taux annuel', 'ref' => 'Estimation indicative, sous réserve d\'acceptation de votre dossier.', 'next' => 'Prochaines étapes', 's1' => 'Étude de votre demande', 's1d' => 'Notre équipe examine votre dossier.', 's2' => 'Prise de contact', 's2d' => 'Un conseiller vous contacte par e-mail ou téléphone.', 's3' => 'Décision et déblocage', 's3d' => 'Réponse sous 48 h, puis versement des fonds.'],
    'en' => ['recap' => 'Summary of your request', 'amount' => 'Amount requested', 'duration' => 'Term', 'months' => 'months', 'type' => 'Loan type', 'monthly' => 'Estimated monthly payment', 'rate' => 'Annual rate', 'ref' => 'Indicative estimate, subject to approval of your application.', 'next' => 'Next steps', 's1' => 'Review of your request', 's1d' => 'Our team is reviewing your application.', 's2' => 'We get in touch', 's2d' => 'An adviser will contact you by email or phone.', 's3' => 'Decision and payout', 's3d' => 'Answer within 48 hours, then funds are released.'],
    'es' => ['recap' => 'Resumen de su solicitud', 'amount' => 'Importe solicitado', 'duration' => 'Plazo', 'months' => 'meses', 'type' => 'Tipo de préstamo', 'monthly' => 'Cuota mensual estimada', 'rate' => 'Tipo anual', 'ref' => 'Estimación orientativa, sujeta a la aprobación de su solicitud.', 'next' => 'Próximos pasos', 's1' => 'Estudio de su solicitud', 's1d' => 'Nuestro equipo revisa su expediente.', 's2' => 'Contacto', 's2d' => 'Un asesor le contactará por correo o teléfono.', 's3' => 'Decisión y desembolso', 's3d' => 'Respuesta en 48 h y, después, entrega de los fondos.'],
    'pl' => ['recap' => 'Podsumowanie wniosku', 'amount' => 'Wnioskowana kwota', 'duration' => 'Okres', 'months' => 'mies.', 'type' => 'Rodzaj pożyczki', 'monthly' => 'Szacowana rata miesięczna', 'rate' => 'Oprocentowanie roczne', 'ref' => 'Szacunek orientacyjny, z zastrzeżeniem akceptacji wniosku.', 'next' => 'Kolejne kroki', 's1' => 'Analiza wniosku', 's1d' => 'Nasz zespół analizuje Twoje zgłoszenie.', 's2' => 'Kontakt', 's2d' => 'Doradca skontaktuje się z Tobą e-mailem lub telefonicznie.', 's3' => 'Decyzja i wypłata', 's3d' => 'Odpowiedź w 48 godzin, następnie wypłata środków.'],
    'bg' => ['recap' => 'Обобщение на заявката', 'amount' => 'Заявена сума', 'duration' => 'Срок', 'months' => 'мес.', 'type' => 'Вид заем', 'monthly' => 'Прогнозна месечна вноска', 'rate' => 'Годишен лихвен процент', 'ref' => 'Ориентировъчна оценка, при одобрение на заявката.', 'next' => 'Следващи стъпки', 's1' => 'Разглеждане на заявката', 's1d' => 'Екипът ни разглежда вашето досие.', 's2' => 'Връзка с вас', 's2d' => 'Консултант ще се свърже с вас по имейл или телефон.', 's3' => 'Решение и изплащане', 's3d' => 'Отговор до 48 часа, след което отпускане на средствата.'],
    'hu' => ['recap' => 'Kérelmének összefoglalója', 'amount' => 'Igényelt összeg', 'duration' => 'Futamidő', 'months' => 'hónap', 'type' => 'Kölcsön típusa', 'monthly' => 'Becsült havi törlesztőrészlet', 'rate' => 'Éves kamat', 'ref' => 'Tájékoztató jellegű becslés, a kérelem elfogadásától függően.', 'next' => 'Következő lépések', 's1' => 'Kérelem vizsgálata', 's1d' => 'Csapatunk áttekinti az ügyét.', 's2' => 'Kapcsolatfelvétel', 's2d' => 'Munkatársunk e-mailben vagy telefonon keresi Önt.', 's3' => 'Döntés és folyósítás', 's3d' => 'Válasz 48 órán belül, majd az összeg folyósítása.'],
    'it' => ['recap' => 'Riepilogo della tua richiesta', 'amount' => 'Importo richiesto', 'duration' => 'Durata', 'months' => 'mesi', 'type' => 'Tipo di prestito', 'monthly' => 'Rata mensile stimata', 'rate' => 'Tasso annuo', 'ref' => 'Stima indicativa, soggetta ad approvazione della pratica.', 'next' => 'Prossimi passi', 's1' => 'Esame della richiesta', 's1d' => 'Il nostro team sta esaminando la tua pratica.', 's2' => 'Ti contattiamo', 's2d' => 'Un consulente ti contatterà via e-mail o telefono.', 's3' => 'Decisione ed erogazione', 's3d' => 'Risposta entro 48 ore, poi erogazione dei fondi.'],
    'de' => ['recap' => 'Zusammenfassung Ihrer Anfrage', 'amount' => 'Gewünschter Betrag', 'duration' => 'Laufzeit', 'months' => 'Monate', 'type' => 'Kreditart', 'monthly' => 'Geschätzte Monatsrate', 'rate' => 'Jahreszins', 'ref' => 'Unverbindliche Schätzung vorbehaltlich der Genehmigung Ihres Antrags.', 'next' => 'Nächste Schritte', 's1' => 'Prüfung Ihrer Anfrage', 's1d' => 'Unser Team prüft Ihren Antrag.', 's2' => 'Kontaktaufnahme', 's2d' => 'Ein Berater meldet sich per E-Mail oder Telefon.', 's3' => 'Entscheidung und Auszahlung', 's3d' => 'Antwort innerhalb von 48 Stunden, danach Auszahlung.'],
    'lt' => ['recap' => 'Jūsų paraiškos santrauka', 'amount' => 'Prašoma suma', 'duration' => 'Trukmė', 'months' => 'mėn.', 'type' => 'Paskolos tipas', 'monthly' => 'Numatoma mėnesio įmoka', 'rate' => 'Metinė palūkanų norma', 'ref' => 'Orientacinis skaičiavimas, priklausomai nuo paraiškos patvirtinimo.', 'next' => 'Tolesni žingsniai', 's1' => 'Paraiškos nagrinėjimas', 's1d' => 'Mūsų komanda peržiūri jūsų paraišką.', 's2' => 'Susisieksime', 's2d' => 'Konsultantas susisieks el. paštu arba telefonu.', 's3' => 'Sprendimas ir išmokėjimas', 's3d' => 'Atsakymas per 48 val., tada lėšų išmokėjimas.'],
    'ro' => ['recap' => 'Rezumatul cererii dumneavoastră', 'amount' => 'Suma solicitată', 'duration' => 'Durata', 'months' => 'luni', 'type' => 'Tipul împrumutului', 'monthly' => 'Rata lunară estimată', 'rate' => 'Rata anuală', 'ref' => 'Estimare orientativă, sub rezerva aprobării dosarului.', 'next' => 'Următorii pași', 's1' => 'Analiza cererii', 's1d' => 'Echipa noastră vă analizează dosarul.', 's2' => 'Vă contactăm', 's2d' => 'Un consilier vă va contacta prin e-mail sau telefon.', 's3' => 'Decizie și virarea fondurilor', 's3d' => 'Răspuns în 48 de ore, apoi virarea fondurilor.'],
    'lv' => ['recap' => 'Jūsu pieteikuma kopsavilkums', 'amount' => 'Pieprasītā summa', 'duration' => 'Termiņš', 'months' => 'mēn.', 'type' => 'Aizdevuma veids', 'monthly' => 'Aprēķinātais ikmēneša maksājums', 'rate' => 'Gada procentu likme', 'ref' => 'Orientējošs aprēķins, atkarīgs no pieteikuma apstiprināšanas.', 'next' => 'Nākamie soļi', 's1' => 'Pieteikuma izskatīšana', 's1d' => 'Mūsu komanda izskata jūsu pieteikumu.', 's2' => 'Sazināšanās', 's2d' => 'Konsultants sazināsies ar jums pa e-pastu vai tālruni.', 's3' => 'Lēmums un izmaksa', 's3d' => 'Atbilde 48 stundu laikā, pēc tam līdzekļu izmaksa.'],
    'nl' => ['recap' => 'Samenvatting van uw aanvraag', 'amount' => 'Gevraagd bedrag', 'duration' => 'Looptijd', 'months' => 'maanden', 'type' => 'Type lening', 'monthly' => 'Geschatte maandlast', 'rate' => 'Jaarlijkse rente', 'ref' => 'Indicatieve schatting, onder voorbehoud van goedkeuring van uw aanvraag.', 'next' => 'Volgende stappen', 's1' => 'Beoordeling van uw aanvraag', 's1d' => 'Ons team bekijkt uw dossier.', 's2' => 'Wij nemen contact op', 's2d' => 'Een adviseur neemt contact op per e-mail of telefoon.', 's3' => 'Beslissing en uitbetaling', 's3d' => 'Antwoord binnen 48 uur, daarna uitbetaling.'],
    'pt' => ['recap' => 'Resumo do seu pedido', 'amount' => 'Montante solicitado', 'duration' => 'Prazo', 'months' => 'meses', 'type' => 'Tipo de empréstimo', 'monthly' => 'Prestação mensal estimada', 'rate' => 'Taxa anual', 'ref' => 'Estimativa indicativa, sujeita à aprovação do seu pedido.', 'next' => 'Próximos passos', 's1' => 'Análise do pedido', 's1d' => 'A nossa equipa está a analisar o seu processo.', 's2' => 'Contacto', 's2d' => 'Um consultor contactá-lo-á por e-mail ou telefone.', 's3' => 'Decisão e desembolso', 's3d' => 'Resposta em 48 h e, depois, entrega dos fundos.'],
    'hr' => ['recap' => 'Sažetak vašeg zahtjeva', 'amount' => 'Traženi iznos', 'duration' => 'Rok', 'months' => 'mjeseci', 'type' => 'Vrsta zajma', 'monthly' => 'Procijenjena mjesečna rata', 'rate' => 'Godišnja stopa', 'ref' => 'Okvirna procjena, podložna odobrenju zahtjeva.', 'next' => 'Sljedeći koraci', 's1' => 'Razmatranje zahtjeva', 's1d' => 'Naš tim razmatra vaš zahtjev.', 's2' => 'Javljamo vam se', 's2d' => 'Savjetnik će vas kontaktirati e-poštom ili telefonom.', 's3' => 'Odluka i isplata', 's3d' => 'Odgovor u roku od 48 sati, zatim isplata sredstava.'],
];
$l = $L[$lang] ?? $L['fr'];

$setting  = \App\Models\LoanSetting::current();
$amount   = (float) $data['amount'];
$months   = (int) $data['darly'];
$ccy      = $data['currency'] ?? 'EUR';
$rate     = (float) $setting->annual_rate;
$r        = $rate / 100 / 12;
$monthly  = ($months > 0)
    ? ($r > 0 ? ($amount * $r * pow(1 + $r, $months)) / (pow(1 + $r, $months) - 1) : $amount / $months)
    : null;
$fmt      = fn ($v) => number_format($v, 2, ',', ' ') . ' ' . $ccy;
@endphp

<x-email-layout
    :title="$t['title']"
    :subtitle="$t['sub']"
    accent="teal"
    :footerNote="$t['noreply']"
    :locale="$lang"
>

  <p class="greeting">{{ $t['greeting'] }}</p>

  <p class="body-text">{!! $t['body'] !!}</p>

  {{-- Récapitulatif --}}
  <p style="font-family:Georgia,serif;font-size:1rem;font-weight:700;color:#0E3B2E;margin:0 0 .6rem">{{ $l['recap'] }}</p>
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #E4E0D6;margin-bottom:.4rem;background:#FBF9F4">
    @foreach ([
        [$l['amount'],   number_format($amount, 0, ',', ' ') . ' ' . $ccy, false],
        [$l['duration'], $months . ' ' . $l['months'], false],
        [$l['type'],     $data['subject'] ?? '—', false],
        [$l['rate'],     number_format($rate, 2, ',', ' ') . ' %', false],
        [$l['monthly'],  $monthly ? $fmt($monthly) : '—', true],
    ] as [$lab, $val, $hi])
    <tr>
      <td style="padding:10px 16px;border-bottom:1px solid #EDE9DD;font-size:.8rem;color:#6F695D;">{{ $lab }}</td>
      <td align="right" style="padding:10px 16px;border-bottom:1px solid #EDE9DD;font-size:{{ $hi ? '.98rem' : '.86rem' }};font-weight:{{ $hi ? 800 : 600 }};color:{{ $hi ? '#9A7736' : '#1A1A17' }};">{{ $val }}</td>
    </tr>
    @endforeach
  </table>
  <p style="font-size:.72rem;color:#8A8474;margin:0 0 1.6rem">{{ $l['ref'] }}</p>

  {{-- Prochaines étapes --}}
  <p style="font-family:Georgia,serif;font-size:1rem;font-weight:700;color:#0E3B2E;margin:0 0 .6rem">{{ $l['next'] }}</p>
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:1.5rem">
    @foreach ([1, 2, 3] as $n)
    <tr>
      <td width="34" valign="top" style="padding:6px 0">
        <div style="width:26px;height:26px;line-height:26px;text-align:center;background:#0E3B2E;color:#DCBE87;font-family:Georgia,serif;font-weight:700;font-size:.85rem">{{ $n }}</div>
      </td>
      <td valign="top" style="padding:6px 0 10px">
        <div style="margin:0;font-size:.88rem;font-weight:700;color:#1A1A17;line-height:1.3">{{ $l['s' . $n] }}</div>
        <div style="margin:0;font-size:.8rem;color:#6F695D;line-height:1.5">{{ $l['s' . $n . 'd'] }}</div>
      </td>
    </tr>
    @endforeach
  </table>

  <div class="alert alert-info">
    <strong>{{ $t['cond_title'] }}</strong>
    <p>{{ $t['cond_body'] }}</p>
  </div>

  <p class="body-text">{{ $t['footer'] }}</p>

  <p class="closing">
    {{ $t['closing'] }}<br>
    <strong>{{ $t['team'] }}</strong>
  </p>

</x-email-layout>
