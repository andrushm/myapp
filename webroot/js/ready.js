jQuery(function () {
    jQuery('[aref]').on('click', function () {
        createAjaxRequest(jQuery(this));
        return false;
    });

    $(document).ready(function () {

        if ($('#statistic').length)         // use this if you are using id to check
        {
            $.ajax({
                url: "getLastYears",
                dataType: "json",
                success: function (data) {
                    $('#statistic').dataTable({
                        "processing": false,
                        "serverSide": false,
                        "paging": false,
                        "ordering": false,
                        searching: false,
                        info: false,
                        //"ajax": "getLastYears"
                        "data": data['aaData'],
                        "columns": data['aoColumnDefs'] //,
                    });
                },
                error: function () {
                    console.log('error');
                }
            });
        }; // if ($('#statistic').length)         // use this if you are using id to check


        if ($('#monitoring').length)         // use this if you are using id to check
        {
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
                        };
                    };
                    suma = suma + parseInt(data[3]);
                    $('#fSum').html(suma + ' кВт');
                },
                "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
                    var TotalMarks = 0;
                    var nCells = nRow.getElementsByTagName('th');
                    for (var ii = 5; ii < 9; ii++) {
                        for (var i = 0; i < aaData.length; i++) {
                            if ((aaData[i][ii] * 1) >= 0) {
                                TotalMarks += aaData[i][ii] * 1;
                            };
                        }
                        nCells[ii].innerHTML = TotalMarks + ' кВт*год';
                        TotalMarks = 0;
                    }
                }
            });

        }  //if ($('#monitoring').length)         // use this if you are using id to check


        if ($('#graphdiv').length)         // use this if you are using id to check
        {
            $.ajax({
                url: "Powers/getLastDayRecords",
                type: "get",
                dataType: "json", //"text",
                success: function (data) {
                    //console.log(data);
                    g = new Dygraph(
                        // containing div
                        document.getElementById("graphdiv"),
                        data.data,
                        {
                            labels: data.title,
                            axes: {
                                x: {
                                    valueFormatter: Dygraph.dateString_,
                                    axisLabelFormatter: Dygraph.dateAxisFormatter,
                                    ticker: Dygraph.dateTicker
                                }
                            },
                            legend: 'always',
                            title: 'Графік потужності',
                            titleHeight: 24,
                            ylabel: 'Потужність, кВт',
                            xlabel: 'Період',
                            labelsDivStyles: {
                                'text-align': 'right',
                                'background': 'none'
                            }
                        }
                    );

                },
                error: function () {
                    console.log('error getLastDayRecords');
                }
            });
        } // if ($('#graphdiv').length)         // use this if you are using id to check
    }); // $(document).ready(function ()

}); //jQuery(function ()