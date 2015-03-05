jQuery(function () {
    jQuery('[aref]').on('click', function () {
        createAjaxRequest(jQuery(this));
        return false;
    });

    $(document).ready(function () {

            var test = [
                { "title": "Engine" },
                { "title": "Browser" },
                { "title": "Platform" },
                { "title": "Version", "class": "center" },
                { "title": "Grade", "class": "center" }
            ];




        $.ajax({
            url: "getLastYears", //"getLastMeters",
            type: "GET",
            dataType: "json",
            success: function (data) {
                console.log(data);
                //$.each(data['aoColumnDefs'], function (index, value) {
                //    console.log(value['sTitle']);
                //    //$('#statistic th:last').after('<th>' + value['sTitle'] + '</th>');
                //});
                //console.log( data['aaData'].data);
                //$('#statistic').dataTable({
                //    "processing": false,
                //    "serverSide": false,
                //    "paging": false,
                //    "ordering": false,
                //    searching: false,
                //    info: false,
                //    //"ajax": "getLastYears"
                //    "data": data['aaData'].data,
                //    "columns": test, //data['aaData'].title
                //    //[
                //    //    { "title": "Engine" },
                //    //    { "title": "Browser" },
                //    //    { "title": "Platform" },
                //    //    { "title": "Version", "class": "center" },
                //    //    { "title": "Grade", "class": "center" }
                //    //]
                //});

            },
            error: function () {
                console.log('error');
            }
        });


        var suma = 0;
        $('#monitoring').dataTable({
            "processing": false,
            "serverSide": false,
            "paging": false,
            "ordering": false,
            searching: false,
            info: false,
            "ajax": "Powers/getLastMeters",
            "createdRow": function (row, data, index) {
                for (var i = 4; i < 8; i++) {
                    if (data[i] < 0) {
                        $('td', row).eq(i).addClass('NoConect');
                    }
                    ;

                }
                ;
                //console.log(parseInt(data[3]));
                suma = suma + parseInt(data[3]);
                //alert(suma);
                $('#fSum').html(suma + ' кВт');
            },
            "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
                var TotalMarks = 0;
                var nCells = nRow.getElementsByTagName('th');
                for (var ii = 5; ii < 9; ii++) {
                    for (var i = 0; i < aaData.length; i++) {
                        if ((aaData[i][ii] * 1) >= 0) {
                            TotalMarks += aaData[i][ii] * 1;
                        }
                        ;
                    }


                    nCells[ii].innerHTML = TotalMarks + ' кВт*год';
                    TotalMarks = 0;
                }
            }
        });

        //$('#statistic').dataTable( {
        //    "processing": false,
        //    "serverSide": false,
        //    "paging": false,
        //    "ordering": false,
        //    "ajax": "getLastYears"
        //} );


        var data = [];

        function onDataReceived(series) {
            console.log(1233);
            //data = $.parseJSON(series);
            //data.push(series);
            console.log(data);

            g = new Dygraph(
                // containing div
                document.getElementById("graphdiv"),

                data
                //series
                //"Date,1.Формовка,2.Механообробка,3.ГЗН,4.Термопласт авт.,5.Вибивка,6.Гальваніка,7.Бункерна,8.Зборка-Пайка акумуляторів,9.Рем.дільниця,10.Зварочна дільниця \n" + "2015-03-01 00:29:52,0,0,0,0,0,0,0, \n" + "2015-03-01 00:59:52,0,0,34,3,1,0,0, \n" + "2015-03-01 01:29:52,0,0,27,3,1,0,0, \n" + "2015-03-01 01:59:42,0,0,34,0,1,0,0, \n" + "2015-03-01 01:59:52,0,0,33,0,1,0,0, \n" + "2015-03-01 02:29:54,0,0,61,0,1,0,0, \n" + "2015-03-01 02:59:54,0,0,3,3,1,0,0, \n" + "2015-03-01 03:29:54,0,0,23,3,1,0,0, \n" + "2015-03-01 03:59:54,0,0,26,3,1,0,0, \n" + "2015-03-01 04:29:55,0,0,6,3,1,0,0, \n" + "2015-03-01 04:59:53,0,0,49,3,1,0,0, \n" + "2015-03-01 05:29:54,0,0,5,0,1,0,0, \n" + "2015-03-01 05:59:52,0,0,3,3,1,0,0, \n" + "2015-03-01 06:29:52,0,0,62,3,1,0,0, \n" + "2015-03-01 06:59:52,0,0,45,3,1,0,0, \n" + "2015-03-01 07:29:52,0,0,50,0,2,0,0, \n" + "2015-03-01 07:59:55,0,0,50,3,1,0,0, \n" + "2015-03-01 08:29:52,0,0,41,3,1,0,0, \n" + "2015-03-01 08:59:55,0,0,1,3,1,0,0, \n" + "2015-03-01 09:29:52,0,0,12,0,1,0,0, \n" + "2015-03-01 09:59:54,0,0,1,3,1,0,0, \n" + "2015-03-01 10:29:53,0,0,1,3,1,0,0, \n" + "2015-03-01 10:59:56,0,0,11,3,1,0,0, \n" + "2015-03-01 11:29:53,0,0,11,3,1,0,0, \n" + "2015-03-01 11:59:51,0,0,1,3,1,0,0, \n" + "2015-03-01 12:29:51,0,0,1,0,1,0,0, \n" + "2015-03-01 12:59:53,0,0,12,3,1,0,0, \n" + "2015-03-01 13:29:51,0,0,1,3,1,0,0, \n" + "2015-03-01 13:59:53,0,0,1,3,1,0,0, \n" + "2015-03-01 14:29:51,0,0,1,0,1,0,0, \n" + "2015-03-01 14:59:51,0,0,11,0,1,0,0, \n" + "2015-03-01 15:29:51,0,0,1,3,1,0,0, \n" + "2015-03-01 15:59:54,0,0,1,3,1,0,0, \n" + "2015-03-01 16:29:54,0,0,11,3,1,0,0, \n" + "2015-03-01 16:59:53,0,0,1,0,1,0,0, \n" + "2015-03-01 17:29:54,0,0,1,0,1,0,0, \n" + "2015-03-01 17:59:54,0,0,1,0,1,0,0, \n" + "2015-03-01 18:29:51,0,0,11,3,1,0,0, \n" + "2015-03-01 18:59:55,0,0,11,0,1,0,0, \n" + "2015-03-01 19:29:51,0,0,1,3,1,0,0, \n" + "2015-03-01 19:59:54,0,0,1,3,1,0,0, \n" + "2015-03-01 20:29:51,0,0,11,3,1,0,0, \n" + "2015-03-01 20:59:51,0,0,11,3,1,0,0, \n" + "2015-03-01 21:29:51,0,0,1,3,1,0,0, \n" + "2015-03-01 21:59:54,0,0,1,3,1,0,0, \n" + "2015-03-01 22:29:52,0,0,11,3,1,0,0, \n" + "2015-03-01 22:59:52,0,0,11,3,1,0,0, \n" + "2015-03-01 23:29:52,0,0,1,0,1,0,0, \n" + "2015-03-01 23:59:53,0,0,1,3,1,0,0, \n" + "2015-03-02 00:29:53,0,0,12,3,1,0,0, \n" + "2015-03-02 00:59:52,0,0,1,3,1,0,0, \n" + "2015-03-02 01:29:52,0,0,1,3,1,0,0, \n" + "2015-03-02 01:59:52,0,0,11,3,1,0,0, \n" + "2015-03-02 02:29:53,0,0,1,3,1,0,0, \n" + "2015-03-02 02:59:52,0,0,1,3,1,0,0, \n" + "2015-03-02 03:29:50,0,0,12,3,1,0,0, \n" + "2015-03-02 03:59:50,0,0,1,3,1,0,0, \n" + "2015-03-02 04:29:53,0,0,11,0,1,0,0, \n" + "2015-03-02 04:59:53,0,0,11,3,1,0,0, \n" + "2015-03-02 05:29:53,0,0,1,3,1,0,0, \n" + "2015-03-02 05:59:50,0,0,1,0,1,0,0, \n" + "2015-03-02 06:29:50,0,0,12,3,1,0,0, \n" + "2015-03-02 06:59:52,0,0,1,3,1,0,0, \n" + "2015-03-02 07:29:53,0,0,1,0,1,0,0, \n" + "2015-03-02 07:59:53,0,0,6,3,1,0,0, \n" + "2015-03-02 08:29:51,0,0,1,3,1,25,0, \n" + "2015-03-02 08:59:50,0,0,41,0,2,24,0, \n" + "2015-03-02 09:29:50,0,11,60,5,1,24,0, \n" + "2015-03-02 09:59:49,0,10,32,8,2,25,1,0 \n" + "2015-03-02 10:29:49,0,4,32,8,4,25,1,0 \n" + "2015-03-02 10:59:49,0,4,59,8,2,25,1,0 \n" + "2015-03-02 11:29:51,0,10,32,9,4,32,1,0 \n" + "2015-03-02 11:59:49,0,8,50,7,4,32,1,0 \n" + "2015-03-02 12:29:49,0,18,42,7,4,27,1,0 \n" + "2015-03-02 12:59:50,0,1,31,0,3,26,0,0 \n" + "2015-03-02 13:29:50,0,2,43,0,3,24,0,0 \n" + "2015-03-02 13:59:50,0,8,44,1,4,18,1,0 \n" + "2015-03-02 14:29:49,0,2,53,1,4,13,1,0 \n" + "2015-03-02 15:00:19,0,2,44,1,4,17,1,0 \n" + "2015-03-02 15:30:18,0,10,44,1,3,38,1,1 \n" + "2015-03-02 16:00:18,0,2,44,4,4,40,1,1 \n"
                ,
                {
                    legend: 'always',
                    title: 'Графік потужності',
                    titleHeight: 24,
                    ylabel: 'Потужність, кВт',
                    xlabel: 'Період',
                    //labels: ['Time', 'Random'],
                    labelsDivStyles: {
                        'text-align': 'right',
                        'background': 'none'
                    }
                }
            );


            // Extract the first coordinate pair; jQuery has parsed it, so
            // the data is now just an ordinary JavaScript object
            //
            //var firstcoordinate = "(" + series.data[0][0] + ", " + series.data[0][1] + ")";
            //button.siblings("span").text("Fetched " + series.label + ", first point: " + firstcoordinate);
            //
            //// Push the new data onto our existing data array
            //
            //if (!alreadyFetched[series.label]) {
            //    alreadyFetched[series.label] = true;
            //    data.push(series);
            //}
            //
            //$.plot("#ThisDaychart", data, options);
        }

        //onDataReceived();

        //$.ajax({
        //    url: "Powers/getLastDayRecords",
        //    type: "GET",
        //    dataType: "json",
        //    success: onDataReceived,
        //    error:function(){console.log('error');}
        //});
    });

});