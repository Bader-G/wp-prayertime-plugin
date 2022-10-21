var date = new Date();
var day = date.getDay();

window.addEventListener('load', () => {
    var barElem = document.getElementById('wfc-prayer-bar');
    document.body.style.top = barElem.offsetHeight+'px';
    barElem.style.top = '-'+barElem.offsetHeight+'px';
    if(localStorage.getItem("prayerTimeLocation") == 'true'){
       barElem.querySelector('.loc-text').textContent = '';
    }
    //if stored data exists
    if (localStorage.getItem("prayerTimeData") && localStorage.getItem("prayerTimeDate")) {
        //if date when data retreived matches today
        if (localStorage.getItem("prayerTimeDate") == day) {
            console.log('verified');
            var data = JSON.parse(localStorage.getItem('prayerTimeData'));
            barElem.querySelector('.fajr').textContent = 'Fajr: ' + data['Fajr'].replace(' (AEST)', '').replace(' (AEDT)', '');
            barElem.querySelector('.sunrise').textContent = 'Sunrise: ' + data['Sunrise'].replace(' (AEST)', '').replace(' (AEDT)', '');
            barElem.querySelector('.duhr').textContent = 'Dhuhr: ' + data['Dhuhr'].replace(' (AEST)', '').replace(' (AEDT)', '');
            barElem.querySelector('.asr').textContent = 'Asr: ' + data['Asr'].replace(' (AEST)', '').replace(' (AEDT)', '');
            barElem.querySelector('.maghrib').textContent = 'Maghrib: ' + data['Maghrib'].replace(' (AEST)', '').replace(' (AEDT)', '');
            barElem.querySelector('.isha').textContent = 'Isha: ' + data['Isha'].replace(' (AEST)', '').replace(' (AEDT)', '');
            document.body.style.top = barElem.offsetHeight+'px';
            barElem.style.top = '-'+barElem.offsetHeight+'px';

        } else {
            console.log('updating times');
            if(localStorage.getItem("prayerTimeLocation")){
                getLocationBasedTime();
            }else{
                initLocation();
            }
            
        }
    } else {
        console.log('getting times');
        initLocation();
    }
    barElem.querySelector('.location-update').onclick = function(){
        getLocationBasedTime();
    }
});

window.onresize = function(){
    var barElem = document.getElementById('wfc-prayer-bar');
    document.body.style.top = barElem.offsetHeight+'px';
    barElem.style.top = '-'+barElem.offsetHeight+'px';
}

function initLocation() {
    getPrayerTimes(-33.86785, 151.20732);
}

function getLocationBasedTime(){
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (pos) {
            getPrayerTimes(pos.coords.latitude, pos.coords.longitude);
            localStorage.setItem('prayerTimeLocation', 'true');
            var barElem = document.getElementById('wfc-prayer-bar');
            barElem.querySelector('.loc-text').textContent = '';

        }, function (error) {
            console.log(error.message);
            localStorage.setItem('prayerTimeLocation', 'false');
        });
    }
}

function getPrayerTimes(lat, long) {
    var barElem = document.getElementById('wfc-prayer-bar');
    document.body.style.top = barElem.offsetHeight+'px';
    barElem.style.top = '-'+barElem.offsetHeight+'px';
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var data = JSON.parse(request.responseText);
            barElem.querySelector('.fajr').textContent = 'Fajr: ' + data['Fajr'].replace(' (AEST)', '').replace(' (AEDT)', '');
            barElem.querySelector('.sunrise').textContent = 'Sunrise: ' + data['Sunrise'].replace(' (AEST)', '').replace(' (AEDT)', '');
            barElem.querySelector('.duhr').textContent = 'Dhuhr: ' + data['Dhuhr'].replace(' (AEST)', '').replace(' (AEDT)', '');
            barElem.querySelector('.asr').textContent = 'Asr: ' + data['Asr'].replace(' (AEST)', '').replace(' (AEDT)', '');
            barElem.querySelector('.maghrib').textContent = 'Maghrib: ' + data['Maghrib'].replace(' (AEST)', '').replace(' (AEDT)', '');
            barElem.querySelector('.isha').textContent = 'Isha: ' + data['Isha'].replace(' (AEST)', '').replace(' (AEDT)', '');
            localStorage.setItem('prayerTimeData', request.responseText);
            localStorage.setItem('prayerTimeDate', day);
            document.body.style.top = barElem.offsetHeight+'px';
            barElem.style.top = '-'+barElem.offsetHeight+'px';
        }
    }
    request.open("GET", php_vars.home+"/wp-json/wfc/v1/prayertimes?lat=" + lat + "&long=" + long);
    request.send();
}