
    <div class="container">
      

        <?php
        
    

            $model_q = "SELECT * FROM models ORDER BY id DESC";
        
        ?>
        <div class="content">
            <br>
            
            
            <div class="l_categories text-right" dir="rtl">
                
                
                <h3>قائمة النماذج المضافة :</h3>
                <div class="row">

                
                <?php
                $fetch_portfs= mysqli_query($con, $model_q);

                if(mysqli_num_rows($fetch_portfs) == 0){
                    ?> <div class="no_items mt-4 mr-auto"><center><p>sorry There is no forms To show ..</p></center></div> <?php
                }

                while($row= mysqli_fetch_array($fetch_portfs)){
                    $port_id= $row['id'];
                    $model_file = $row['file'];
                    $model_name = $row['name'];
                
                    ?>
                    


                    
                

                <div class="col-lg-4 portfb">

                    <div class="text-center p_image">
                        <a href="../admin/download_model.php?id=<?php echo $port_id; ?>" class="btn btn-success">
                        <img src="../assets/images/icons/download.png">
                        </a>
                    </div>
                    <div class="text-center">
                        <h6 class="mt-1"><?php echo $model_name; ?>&nbsp;<br><br>
                        </h6>
                    </div>


                </div>
                <br>
                
                <script>
                    $(document).ready(function(){

                        $('#port<?php echo $port_id; ?>').on('click', function(){
                            
                            bootbox.confirm("Are you sure you want to delete this Portfolio ?", function(result){

                                if(result == true){
                                
                                    $.post("handlers/delete_port.php?port_id=<?php echo $port_id; ?>", {result:result});
                                    window.location.reload();
                                }
                            });

                        });


                    }); // end of all document.ready
                </script>


                            
                
                <?php

                
                } // end of while loop
                
                ?>

                </div>
            </div>
        </div>

    </div>
    </section>


    
    
</body>
</html>