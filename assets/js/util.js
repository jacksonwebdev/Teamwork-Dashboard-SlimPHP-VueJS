function log( str ) {
    console.log( '%c  ' + str + '  ', 'background: #0277BC; color: #fff; border: 2px solid #fff; border-radius: 5px; padding: 2px 5px' );
}

function getCurrentMonth() {
    var months    = ['January','February','March','April','May','June','July','August','September','October','November','December'];
    var now       = new Date();
    var thisMonth = months[now.getMonth()]; // getMonth method returns the month of the date (0-January :: 11-December)
    return thisMonth;
    // check also http://stackoverflow.com/questions/4822852/how-to-get-the-day-of-week-and-the-month-of-the-year
}

export default { 
    log,
    getCurrentMonth
}