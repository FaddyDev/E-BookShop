/*DATE TIME SCRIPT */ 
	function display_c(){
	var refresh=1000; // Refresh rate in milli seconds
	mytime=setTimeout('display_ct()',refresh)
	}
	
	function display_ct() {
	var strcount
	var d = new Date()
	var DayOfMonth = d.getDate();
    var DayOfWeek = d.getDay();
    var Month = d.getMonth();
    var Year = d.getFullYear();
    var Hours = d.getHours();
    var Minutes = d.getMinutes();
    var Seconds = d.getSeconds();

    switch (DayOfWeek) {
    case 0:
        day = "Sun";
        break;
    case 1:
        day = "Mon";
        break;
    case 2:
        day = "Tue";
        break;
    case 3:
        day = "Wed";
        break;
    case 4:
        day = "Thu";
        break;
    case 5:
        day = "Fri";
        break;
    case 6:
        day = "Sat";
        break;
    }

    switch (Month) {
    case 0:
        month = "Jan";
        break;
    case 1:
        month = "Feb";
        break;
    case 2:
        month = "Mar";
        break;
    case 3:
        month = "Apr";
        break;
    case 4:
        month = "May";
        break;
    case 5:
        month = "Jun";
        break;
    case 6:
        month = "Jul";
        break;
    case 7:
        month = "Aug";
        break;
    case 8:
        month = "Sep";
        break;
    case 9:
        month = "Oct";
        break;
    case 10:
        month = "Nov";
        break;
    case 11:
        month = "Dec";
        break;
    }

    var theDate = day + ", " + DayOfMonth + " " + month + "  " + Year + " - " + Hours + ":" + Minutes + ":" + Seconds;

	document.getElementById('ct').innerHTML = theDate;
	tt=display_c();
	}