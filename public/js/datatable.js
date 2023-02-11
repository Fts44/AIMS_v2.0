function datatable_class(table_id){
    //set datatable
    let datatableClass = $(table_id).DataTable({
        scrollX: true,
        pageLength: 25,
        scrollX: true,
        order: [],
        processing: true,
        dom: 'lfrtipB',
        "lengthMenu": [25 ,50, 100],
        buttons: [
            'csv', 'excel',
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                customize : function(doc){
                    var colCount = new Array();
                    $(table_id).find('tbody tr:first-child td').each(function(){
                        if($(this).attr('colspan')){
                            for(var i=1;i<=$(this).attr('colspan');$i++){
                                colCount.push('*');
                            }
                        }
                        else{ 
                            colCount.push('*'); 
                        }
                    });
                    doc.content[1].table.widths = colCount;
                }
            }
        ]
    })
   
}

function datatable_no_btn_class(table_class){
    let datatableClass = $(table_class).DataTable({
        order: [],
        scrollX: true,
        processing: true,
        pageLength: 25,
        "lengthMenu": [25 ,50, 100],
    });
}

function redraw_datatable_class(table_class){
    let table = $(table_class).DataTable();
    table.columns.adjust().draw();
}

function resize_adjust_datatable(table_class){
    let th = table_class+' tr th';
    datatable.order([[ $(th).length-1, 'asc']]).draw();
}