jQuery.extend(jQuery.fn.dataTableExt.oSort, {
    "stringMonthYear-pre": function (s) {
        var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
 
        var dateComponents = s.split(" ");
        dateComponents[0] = dateComponents[0].replace(",", "");
        dateComponents[1] = jQuery.trim(dateComponents[1]);
 
        var year = dateComponents[1];
 
        var month = 0;
        for (var i = 0; i < months.length; i++) {
            if (months[i].toLowerCase() == dateComponents[0].toLowerCase().substring(0,3)) {
                month = i;
                break;
            }
        }
 
        return new Date(year, month, 1);
    },
 
    "stringMonthYear-asc": function (a, b) {
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },
 
    "stringMonthYear-desc": function (a, b) {
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    }
});