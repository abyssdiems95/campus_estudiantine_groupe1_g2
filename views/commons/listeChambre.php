        
                <h4 class="text-center">Liste des chambres</h4>
                <table class="table" id="update_cont" >

                    <tr>
                        <td><img id="delete_elmt" src="<?=BASE_URL?>/public/images/delete_sweep-24px.svg" alt="-"/></td>
                        <td><img  src="<?=BASE_URL?>/public/images/create-24px.svg" alt="-"/></td>
                        <td>&nbsp;</td>
                    </tr>
                </table>  
                <table class="table table-hover" >

                    <thead>
                    <tr  class="bg-light">
                        <td><input type="checkbox" name="select_etudiant" class="select_all"/></td>
                        <th>Num</th>
                        <th>Num Bat</th>
                        <th>Type</th>
                    </tr>
                    </thead>
                    <tbody id='table'>
                    </tbody>
                </table>   <br>
    <br>
    <br>
    <div class="col justify-content-end pull-bottom position-absolute fixed-bottom">
        <button type="button" id="btn_precedent" name="precedent" value='nav_pre' class="btn_nav btn-sm ubtn float-left">Précédent</button>
        <button type="button" id="btn_suivant" name="suivant" value='nav_suiv' class="btn_nav btn-sm ubtn float-right">Suivant</button>
    </div>
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<script>
$(function(){
        const URL='http://localhost/sa/campus_estudiantine';
        var tab_checkedid={};
        var tab_allId=[];
        let offset=0;
//tab id to remove
        var id_rm=[];
        const tbody=$("#table");
        $('#update_cont').hide();
        // $.ajax({
        //     type:"POST",
        //     url:`${URL}/chambre/liste`,
        //     data:{limit:5,offset:offset},
        //     dataType:"JSON",
        //     success:(data,status)=>{
        //     console.log(data);
        //     tbody.html('');
        //     printData(data);
        //     offset+=5;
        //     }
        // });
        sendData(offset);
    $('#table').on("click",".select_etu",function(){

      var tab=[]
        if($(this).parents('tr').attr("id"))
        {
            tab = $(this).parents("tr").attr("id").split("_");
            //console.log(tab);
        }
        $('#update_cont').show();
        if($(this).is(':checked'))
        {
                // if($(this).is(":checked"))
                // {
            tab_checkedid[$(this).val()]=$(this).val();
                //updateContUp();
        }else
        {
            delete  tab_checkedid[$(this).val()];
        }
    });
    $(".select_all").on("change",()=>{
        if($(".select_all").is(":checked"))
        {
           tab_checkedid={};

            for(i in tab_allId)
            {
                tab_checkedid[tab_allId[i]]=tab_allId[i]
            }
            console.log(tab_checkedid);
            $(".select_etu").prop('checked',true);
            $('#update_cont').show();
        }else
        {
            id_rm=[];
            $(".select_etu").prop('checked',false);
            $('#update_cont').hide();
        }
    });
//-----------------------------------------------------
//Afficher Montrer la navigation
//--------------------------------------------------
function showhidenav(offset,nbrpage)
{
	if(offset===0 || nbrpage===0)
	{
		$('#btn_precedent').hide();
	}
	else
	{
		$('#btn_precedent').show();
	}
	if((nbrpage-offset)<5)
	{

		$('#btn_suivant').hide();
	}else
	{
		$('#btn_suivant').show();
	}
}
//-----------------------------------------------------------



//-------------------------------------------------
//FUNCTION SENDDATA
//-------------------------------------------------
function sendData(offs)
{
        $.ajax({
            type:"POST",
            url:`${URL}/chambre/liste`,
            data:{limit:5,offset:offs},
            dataType:"JSON",
            success:(data,status)=>{
            console.log(data);
            tbody.html('');
            printData(data);
            offset+=5;
            }
        });

}
//---------------------------------------------------------
// DELETE FUNCTION
//---------------------------------------------------------
    $("#delete_elmt").on('click',function(){
        for(x in tab_checkedid)
        {
            id_rm.push(x);
            $(`#id_${x}`).hide();

        }
        $(".select_all").prop('checked',false);
        $.ajax({
            type:"POST",
            url:`${URL}/chambre/deleteChambre`,
            data:{deleteId:id_rm},
           // dataType:"JSON",
            success:(data,status)=>{
                    if(data!=="error")
                    {
                        alert("suppression fait avec succes");
                    }
                    else
                    {
                        alert('Erreur lors de la suppression');
                    }
            } 
        });

    })

    $('#btn_suivant').on('click',function(){
        sendData(offset);
    });
    $('#btn_precedent').on('click',function(){
       offs= offset-=5;
        sendData(offs);
    });
//-------------------------------------------------------------------
// DELETE FUNCTION
//-------------------------------------------------------------------

    function updateContUp()
    {
        sendData();
    }
    

        function printData(data)
        {
            $.each(data,function(id,cham){
                tab_allId.push(cham.numero);
                tbody.append(`
                    <tr id="id_${cham.numero}">
                        <td id="ck_${cham.numero}"><input type="checkbox" name="select_etudiant${cham.numero}" value="${cham.numero}" class="select_etu"/></td>
                        <td>${cham.numero}</td>
                        <td>${cham.numero_batiment}</td>
                        <td>${cham.type}</td>
                        
                    </tr>

                `)
            });
        }

})

</script>