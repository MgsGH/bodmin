$(document).ready(function() {

    let v = {

        titleText: $('#titleText'),
        bannerHeader: $('#bannerHeader'),
        bannerIntroText: $('#bannerIntroText'),

        kontaktHeader:  $('#kontakt-header'),
        kontaktSubHeader: $('#kontakt-sub-header'),
        post : $('#post'),
        country : $('#country'),
        zipPrefix : $('#zipPrefix'),
        inbetalningar : $('#inbetalningar'),
        payments : $('#payments'),
        mottagare: $('#mottagare'),
        mottagareTwo: $('#mottagareTwo'),
        bidrag: $('#bidrag'),
        telefon : $('#telefon'),
        general : $('#general'),
        telefonNo : $('#telefon-no'),
        donationsText : $('.donations'),
        donations : $('#donations'),
        sophieTelefon : $('#sophie-telefon'),
        bjornTelefon : $('#bjorn-telefon'),
        guidings : $('#guidings'),
        guidingsIntro : $('#guidingsIntro'),
        gVar : $('#g-var'),
        logi : $('#logi'),
        logiIntro : $('#logiIntro'),
        lVar : $('#l-var'),

        hdrSkadadeFaglar : $('#hdrSkadadeFaglar'),
        hdrBrevDuvor     : $('#hdrBrevDuvor'),
        brevDuveIntro    : $('#brevDuveIntro'),
        brevDuveLink     : $('#brevDuveLink'),
        intro            : $('#intro'),
        kfv              : $('#kfv'),

        lang: {
            current: $('#lang').text(),
        },

    }

    function getTexts() {


        // E N G E L S K A
        if (v.lang.current === '1') {
            v.lang = {

                titleText : 'Falsterbo Bird Observatory - About us',
                bannerHeader : 'About us - Falsterbo Bird Observatory',
                bannerIntroText : 'Falsterbo bird observatory was founded by the regional ornitological society <a href="https://skof.se/">Skånes Ornitologiska Förening (SkOF)</a> 1955. SkOFs still provides the overall organizational structure for the work which of course has grown significantly over the years. At present we have staffing and activities throughout the year. The visible migration count, the ringing, and the public outreach are now well known in the neighbourhood.',
                hdrSkadadeFaglar : 'Injured birds and abandoned nestlings',
                hdrBrevDuvor : 'Homing pigeons',
                brevDuveIntro : 'Homing pigeons comes in many different colors. The bird shown here is a rather modest example, but note the colored plastic rings, typical for homing pigeons.',
                brevDuveLink : 'Have you found an exhausted homing pigeon kindly contact <a href="https://brevduvesport.net/tillvaratagen-duva.html">Svenska Brevduveförbundet (page in Swedish)</a>',
                intro : 'Falsterbo Bird Observatory is not certified for receiving injured birds for rehabilitation, see below for further contact information',
                kfv : 'Caretakers are reached through the association Katastrofhjälp – Fåglar och Vilt. Kindly click <a href="http://www.kfv-riks.se/default.asp?iID=GFLKLF">here for a complete list of focal points in the province of Skåne (in Swedish)</a>',

                kontaktHeader : 'Contact' ,
                kontaktSubHeader: 'The bird observatory' ,
                post : 'Mailing address' ,
                inbetalningar : 'Payments' ,
                mottagare: 'Recipient' ,
                payments : 'Wares, lodging, guiding, etc.',
                zipPrefix : 'SE-',
                country : 'Sweden',
                telefon : 'Telephone' ,
                telefonNo : '+46 (0)736-254 256' ,
                donations : 'Donations (see <a href="/omoss/stod.php?lang=en">support us</a>)',
                bidrag : 'Donations',
                general : 'General inquiries',
                sophieTelefon : '+46 (0)705-68 58 10' ,
                bjornTelefon : '+46 (0)703-33 94 99' ,
                guidings : 'Guiding' ,
                guidingsIntro : 'Takes place by the',
                gVar : ' light house, Falsterbo' ,
                logi : 'Lodging' ,
                logiIntro : 'Sjögatan, ',
                lVar : '<a href="/logi/?lang=en">Falsterbo bird observatory</a>',
            }

        }

        // S V E N S K A
        if (v.lang.current === '2') {
            v.lang = {

                titleText : 'Falsterbo Fågelstation - Om oss',
                bannerHeader : 'Om oss - Falsterbo Fågelstation',
                bannerIntroText : 'Falsterbo fågelstation grundades av <a href="https://skof.se/">Skånes Ornitologiska Förening (SkOF)</a> 1955. SkOFs är fortfarande huvudman för verksamheten som naturligtvis har växt betydligt genom åren. Numera har vi bemanning och verksamhet i stort sett året runt. Sträckräkningarna, ringmärkningen och inte minst guidningarna är numera välkända i trakten.',
                allmkontaktHeader : 'Alla ärenden' ,
                kontaktHeader : 'Kontakt' ,

                intro : 'Falsterbo fågelstation har inte behörighet att ta hand om skadade djur för rehabilitering, se vidare nedan.',
                hdrSkadadeFaglar : 'Skadade fåglar och fågelungar',
                hdrBrevDuvor : 'Brevduvor',
                brevDuveIntro : 'Brevduvor är mycket variabla. Bilden visar en ganska modest färgad individ med de typiska färgade ringarna.',
                brevDuveLink : 'Har du funnit en slutkörd brevduva vänligen kontakta <a href="https://brevduvesport.net/tillvaratagen-duva.html">Svenska Brevduveförbundet</a>',
                kfv : 'Viltrehabiliterare nås via föreningen Katastrofhjälp – Fåglar och Vilt. Klicka <a href="http://www.kfv-riks.se/default.asp?iID=GFLKLF">här för en komplett lista av rehabiliterare i Skåne</a>',

                kontaktSubHeader: 'Fågelstationen' ,
                post : 'Postadress' ,
                inbetalningar : 'Inbetalningar' ,
                zipPrefix : '',
                country : '',
                payments : 'Varor, logi, guidningar, etc.',
                mottagare: 'Betalningsmottagare' ,
                telefonNo : '0736-254 256' ,
                donations : 'Spontana bidrag (se <a href="/omoss/stod.php">stöd stationen</a>)',
                donationsText : 'Bidrag',
                general : 'Förfrågningar - alla ärenden',
                sophieTelefon : '0705-68 58 10' ,
                bjornTelefon : '0703-33 94 99' ,
                guidings : 'Guidningar' ,
                guidingsIntro : 'Sker vid',
                gVar : ' Falsterbo fyr' ,
                logi : 'Logi' ,
                logiIntro : 'Sjögatan, ',
                bidrag : 'Donationer',
                lVar : '<a href="/logi/?lang=en">Falsterbo fågelstation</a>' ,
            }
        }

    }


    function setTexts() {

        v.titleText.text(v.lang.titleText);
        v.bannerHeader.html(v.lang.bannerHeader);
        v.bannerIntroText.html(v.lang.bannerIntroText);

        v.kontaktHeader.text(v.lang.kontaktHeader);
        v.kontaktSubHeader.text(v.lang.kontaktSubHeader);
        v.post.text(v.lang.post);
        v.zipPrefix.text(v.lang.zipPrefix);

        v.country.text(v.lang.country);
        v.inbetalningar.text(v.lang.inbetalningar);
        v.payments.text(v.lang.payments);
        v.mottagare.text(v.lang.mottagare);
        v.mottagareTwo.text(v.lang.mottagare);
        v.donations.html(v.lang.donations);
        v.donationsText.text(v.lang.donationsText);
        v.general.text(v.lang.general);
        v.telefon.text(v.lang.telefon);
        v.telefonNo.text(v.lang.telefonNo);
        v.sophieTelefon.text(v.lang.sophieTelefon);
        v.bjornTelefon.text(v.lang.bjornTelefon);
        v.guidings.text(v.lang.guidings);
        v.guidingsIntro.text(v.lang.guidingsIntro);
        v.gVar.text(v.lang.gVar);
        v.logi.text(v.lang.logi);
        v.logiIntro.text(v.lang.logiIntro);
        v.lVar.html(v.lang.lVar);

        v.intro.text(v.lang.intro);
        v.hdrSkadadeFaglar.text(v.lang.hdrSkadadeFaglar);
        v.hdrBrevDuvor.text(v.lang.hdrBrevDuvor);
        v.brevDuveIntro.text(v.lang.brevDuveIntro);
        v.bidrag.text(v.lang.bidrag);
        v.brevDuveLink.html(v.lang.brevDuveLink);
        v.kfv.html(v.lang.kfv);



    }

    getTexts();
    setTexts();


});