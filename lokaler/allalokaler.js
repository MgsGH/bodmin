
    function initMap()
    {
        let fboCenter;
        let myOptions;
        fboCenter = new google.maps.LatLng(55.4220, 12.9067);
        let mapType = google.maps.MapTypeId.SATELLITE;
        let bounds = new google.maps.LatLngBounds(); //Makes an empty bounds object
        myOptions = {
            zoom: 12,
            center: fboCenter,
            mapTypeId: mapType
        };
        let map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);


        /*------------------------------------------------------ Nabben -----------------------------------------------*/

        var point = new google.maps.LatLng(55.3780, 12.8115)
        let nabben = new google.maps.Marker
        (
            {
                position: point,
                map: map,
                url: 'https://www.falsterbofagelstation.se/birdwatch/lokaler/nabb_s.php',
                title: 'Nabben',
                icon: 'https://www.falsterbofagelstation.se/birdwatch/kartor/icons/icong1.png'
            }
        );
        bounds.extend(point);

        google.maps.event.addListener(nabben, 'click', function() {
            window.location.href = nabben.url;
            window.open(this.url, '_self');
        });

        /* ----------------------------------------------------- Fyren -------------------------------------------*/
        point = new google.maps.LatLng(55.3838, 12.8167);
        let fyren = new google.maps.Marker
        (
            {
                position: point,
                map: map,
                url: 'https://www.falsterbofagelstation.se/birdwatch/lokaler/nabb_s.php',
                title: 'Falsterbo Fyr',
                icon: 'https://www.falsterbofagelstation.se/birdwatch/kartor/icons/icong2.png'
            }
        );
        bounds.extend(point);

        google.maps.event.addListener(fyren, 'click', function() {
            window.location.href = fyren.url;
            window.open(this.url, '_self');
        });

        /* ---------------------------------------------------- Kolabacken ---------------------------------------*/
        point = new google.maps.LatLng(55.3841, 12.8226);
        let kolabacken = new google.maps.Marker
        (
            {
                position: point,
                map: map,
                url: 'https://www.falsterbofagelstation.se/birdwatch/lokaler/nabb_s.php',
                title: 'Kolabacken',
                icon: 'https://www.falsterbofagelstation.se/birdwatch/kartor/icons/icong3.png'
            }
        );
        bounds.extend(point);

        google.maps.event.addListener(kolabacken, 'click', function() {
            window.location.href = kolabacken.url;
            window.open(this.url, '_self');
        });


        point = new google.maps.LatLng(55.3910, 12.8220);
        marker = new google.maps.Marker
        (
            {
                position: point,
                map: map,
                url: 'https://www.falsterbofagelstation.se/birdwatch/lokaler/nabb_s.php',
                title: 'Södra Flommen',
                icon: 'https://www.falsterbofagelstation.se/birdwatch/kartor/icons/icong4.png'
            }
        );
        bounds.extend(point);

        google.maps.event.addListener(marker, 'click', function() {
            window.location.href = marker.url;
            window.open(this.url, '_self');
        });

        point = new google.maps.LatLng(55.3900, 12.8420);
        marker = new google.maps.Marker
        (
            {
                position: point,
                map: map,
                url: 'https://www.falsterbofagelstation.se/birdwatch/lokaler/nabb_s.php',
                title: 'Falsterbo park',
                icon: 'https://www.falsterbofagelstation.se/birdwatch/kartor/icons/icong5.png'
            }
        );
        bounds.extend(point);

        google.maps.event.addListener(marker, 'click', function() {
            window.location.href = marker.url;
            window.open(this.url, '_self');
        });

        point = new google.maps.LatLng(55.4150, 12.8330);
        marker = new google.maps.Marker
        (
            {
                position: point,
                map: map,
                url: 'https://www.falsterbofagelstation.se/birdwatch/lokaler/knosen_s.php',
                title: 'Skanör, Hamnvägen',
                icon: 'https://www.falsterbofagelstation.se/birdwatch/kartor/icons/icong6.png'
            }
        );
        bounds.extend(point);

        google.maps.event.addListener(marker, 'click', function() {
            window.location.href = marker.url;
            window.open(this.url, '_self');
        });

        point = new google.maps.LatLng(55.4220, 12.8450);
        marker = new google.maps.Marker
        (
            {
                position: point,
                map: map,
                url: 'https://www.falsterbofagelstation.se/birdwatch/lokaler/knosen_s.php',
                title: 'Bakdjupet',
                icon: 'https://www.falsterbofagelstation.se/birdwatch/kartor/icons/icong7.png'
            }
        );
        bounds.extend(point);

        google.maps.event.addListener(marker, 'click', function() {
            window.location.href = marker.url;
            window.open(this.url, '_self');
        });

        point = new google.maps.LatLng(55.4380, 12.8420);
        marker = new google.maps.Marker
        (
            {
                position: point,
                map: map,
                url: 'https://www.falsterbofagelstation.se/birdwatch/lokaler/knosen_s.php',
                title: 'Skanörs revlar',
                icon: 'https://www.falsterbofagelstation.se/birdwatch/kartor/icons/icong8.png'
            }
        );
        bounds.extend(point);

        google.maps.event.addListener(marker, 'click', function() {
            window.location.href = marker.url;
            window.open(this.url, '_self');
        });

        point = new google.maps.LatLng(55.4380, 12.8620);
        marker = new google.maps.Marker
        (
            {
                position: point,
                map: map,
                url: 'https://www.falsterbofagelstation.se/birdwatch/lokaler/knosen_s.php',
                title: 'Knösen',
                icon: 'https://www.falsterbofagelstation.se/birdwatch/kartor/icons/icong9.png'
            }
        );
        bounds.extend(point);

        google.maps.event.addListener(marker, 'click', function() {
            window.location.href = marker.url;
            window.open(this.url, '_self');
        });

        point = new google.maps.LatLng(55.4260, 12.8610);
        marker = new google.maps.Marker
        (
            {
                position: point,
                map: map,
                url: 'https://www.falsterbofagelstation.se/birdwatch/lokaler/knosen_s.php',
                title: 'Knävången',
                icon: 'https://www.falsterbofagelstation.se/birdwatch/kartor/icons/icong10.png'
            }
        );
        bounds.extend(point);

        google.maps.event.addListener(marker, 'click', function() {
            window.location.href = marker.url;
            window.open(this.url, '_self');
        });

        point = new google.maps.LatLng(55.4150, 12.8780);
        marker = new google.maps.Marker
        (
            {
                position: point,
                map: map,
                url: 'https://www.falsterbofagelstation.se/birdwatch/lokaler/knosen_s.php',
                title: 'F.d. soptippen',
                icon: 'https://www.falsterbofagelstation.se/birdwatch/kartor/icons/icong11.png'
            }
        );
        bounds.extend(point);

        google.maps.event.addListener(marker, 'click', function() {
            window.location.href = marker.url;
            window.open(this.url, '_self');
        });

        point = new google.maps.LatLng(55.4090, 12.8470);
        marker = new google.maps.Marker
        (
            {
                position: point,
                map: map,
                url: 'https://www.falsterbofagelstation.se/birdwatch/lokaler/knosen_s.php',
                title: 'Skanörs park',
                icon: 'https://www.falsterbofagelstation.se/birdwatch/kartor/icons/icong12.png'
            }
        );
        bounds.extend(point);

        google.maps.event.addListener(marker, 'click', function() {
            window.location.href = marker.url;
            window.open(this.url, '_self');
        });

        point = new google.maps.LatLng(55.4070, 12.8870);
        marker = new google.maps.Marker
        (
            {
                position: point,
                map: map,
                url: 'https://www.falsterbofagelstation.se/birdwatch/lokaler/ljungen_s.php',
                title: 'Banvallen',
                icon: 'https://www.falsterbofagelstation.se/birdwatch/kartor/icons/icong13.png'
            }
        );
        bounds.extend(point);

        google.maps.event.addListener(marker, 'click', function() {
            window.location.href = marker.url;
            window.open(this.url, '_self');
        });

        point = new google.maps.LatLng(55.4000, 12.8780);
        marker = new google.maps.Marker
        (
            {
                position: point,
                map: map,
                url: 'https://www.falsterbofagelstation.se/birdwatch/lokaler/ljungen_s.php',
                title: 'Skanörs Ljung',
                icon: 'https://www.falsterbofagelstation.se/birdwatch/kartor/icons/icong14.png'
            }
        );
        bounds.extend(point);

        google.maps.event.addListener(marker, 'click', function() {
            window.location.href = marker.url;
            window.open(this.url, '_self');
        });

        point = new google.maps.LatLng(55.3940, 12.8920);
        marker = new google.maps.Marker
        (
            {
                position: point,
                map: map,
                url: 'https://www.falsterbofagelstation.se/birdwatch/lokaler/ljungen_s.php',
                title: 'Ängsnäset',
                icon: 'https://www.falsterbofagelstation.se/birdwatch/kartor/icons/icong15.png'
            }
        );
        bounds.extend(point);

        google.maps.event.addListener(marker, 'click', function() {
            window.location.href = marker.url;
            window.open(this.url, '_self');
        });

        point = new google.maps.LatLng(55.3860, 12.9230);
        marker = new google.maps.Marker
        (
            {
                position: point,
                map: map,
                url: 'https://www.falsterbofagelstation.se/birdwatch/lokaler/ljungen_s.php',
                title: 'Stenudden',
                icon: 'https://www.falsterbofagelstation.se/birdwatch/kartor/icons/icong16.png'
            }
        );
        bounds.extend(point);

        google.maps.event.addListener(marker, 'click', function() {
            window.location.href = marker.url;
            window.open(this.url, '_self');
        });

        point = new google.maps.LatLng(55.4040, 12.9390);
        marker = new google.maps.Marker
        (
            {
                position: point,
                map: map,
                url: 'https://www.falsterbofagelstation.se/birdwatch/lokaler/ljungen_s.php',
                title: 'Falsterbokanalen',
                icon: 'https://www.falsterbofagelstation.se/birdwatch/kartor/icons/icong17.png'
            }
        );
        bounds.extend(point);

        google.maps.event.addListener(marker, 'click', function() {
            window.location.href = marker.url;
            window.open(this.url, '_self');
        });

        point = new google.maps.LatLng(55.4110, 12.9230);
        marker = new google.maps.Marker
        (
            {
                position: point,
                map: map,
                url: 'https://www.falsterbofagelstation.se/birdwatch/lokaler/ljungen_s.php',
                title: 'Black',
                icon: 'https://www.falsterbofagelstation.se/birdwatch/kartor/icons/icong18.png'
            }
        );
        bounds.extend(point);

        google.maps.event.addListener(marker, 'click', function() {
            window.location.href = marker.url;
            window.open(this.url, '_self');
        });

        point = new google.maps.LatLng(55.4480, 12.9500);
        marker = new google.maps.Marker
        (
            {
                position: point,
                map: map,
                url: 'https://www.falsterbofagelstation.se/birdwatch/lokaler/fotev_s.php',
                title: 'Lilla Hammars näs',
                icon: 'https://www.falsterbofagelstation.se/birdwatch/kartor/icons/icong19.png'
            }
        );
        bounds.extend(point);

        google.maps.event.addListener(marker, 'click', function() {
            window.location.href = marker.url;
            window.open(this.url, '_self');
        });

        point = new google.maps.LatLng(55.4367, 12.9656);
        marker = new google.maps.Marker
        (
            {
                position: point,
                map: map,
                url: 'https://www.falsterbofagelstation.se/birdwatch/lokaler/fotev_s.php',
                title: 'Inre Foteviken',
                icon: 'https://www.falsterbofagelstation.se/birdwatch/kartor/icons/icong20.png'
            }
        );
        bounds.extend(point);

        google.maps.event.addListener(marker, 'click', function() {
            window.location.href = marker.url;
            window.open(this.url, '_self');
        });

        point = new google.maps.LatLng(55.4480, 12.9720);
        marker = new google.maps.Marker
        (
            {
                position: point,
                map: map,
                url: 'https://www.falsterbofagelstation.se/birdwatch/lokaler/fotev_s.php',
                title: 'Vellinge ängar',
                icon: 'https://www.falsterbofagelstation.se/birdwatch/kartor/icons/icong21.png'
            }
        );
        bounds.extend(point);

        google.maps.event.addListener(marker, 'click', function() {
            window.location.href = marker.url;
            window.open(this.url, '_self');
        });

        point = new google.maps.LatLng(55.4777, 12.9549);
        marker = new google.maps.Marker
        (
            {
                position: point,
                map: map,
                url: 'https://www.falsterbofagelstation.se/birdwatch/lokaler/fotev_s.php',
                title: 'Eskilstorps ängar',
                icon: 'https://www.falsterbofagelstation.se/birdwatch/kartor/icons/icong22.png'
            }
        );
        bounds.extend(point);

        google.maps.event.addListener(marker, 'click', function() {
            window.location.href = marker.url;
            window.open(this.url, '_self');
        });

        point = new google.maps.LatLng(55.4777, 12.9292);
        marker = new google.maps.Marker
        (
            {
                position: point,
                map: map,
                url: 'https://www.falsterbofagelstation.se/birdwatch/lokaler/fotev_s.php',
                title: 'Eskilstorps holmar',
                icon: 'https://www.falsterbofagelstation.se/birdwatch/kartor/icons/icong23.png'
            }
        );
        bounds.extend(point);

        google.maps.event.addListener(marker, 'click', function() {
            window.location.href = marker.url;
            window.open(this.url, '_self');
        });

        point = new google.maps.LatLng(55.3930, 12.9930);
        marker = new google.maps.Marker
        (
            {
                position: point,
                map: map,
                url: 'https://www.falsterbofagelstation.se/birdwatch/lokaler/fotev_s.php',
                title: 'Fredshög',
                icon: 'https://www.falsterbofagelstation.se/birdwatch/kartor/icons/icong24.png'
            }
        );
        bounds.extend(point);

        google.maps.event.addListener(marker, 'click', function() {
            window.location.href = marker.url;
            window.open(this.url, '_self');
        });

    }
