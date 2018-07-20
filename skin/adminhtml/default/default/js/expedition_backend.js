var $j = jQuery.noConflict();

function editExpeditionDate (url, order_id, date_expedition) {
    var dateExpedition = prompt("Expedition Date:", date_expedition);

    if (dateExpedition == null || dateExpedition === "") {
        // Cancel, Do Nothing...
    } else {
        $j.ajax({
            url: url,
            type: "POST",
            data: "date="+dateExpedition+"&order_id="+order_id,
            success: function(data) {
                $j("#date_expedition_value").html(dateExpedition+" (<span style=\"color:green;\">update with success</span>)")
            }
        });

    }
}