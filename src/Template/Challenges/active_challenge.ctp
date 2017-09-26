<div class="row">
    <div class="col-lg-12">
        <!-- <div class="ibox-content"> -->
        <?= $this->Form->create($activeChallenge, ['data-toggle'=>'validator','class' => 'form-horizontal'])?>

        <div class="row">
            <div class="m-t-md">
                <div class="p-lg ">
                    <img src="<?= $activeChallenge->image_url ?>" class = "img-responsive img-shadow"/>
                </div>
            </div>
            <div id = "deleteData">        
                <div class="m-t-md text-center">
                    <h2><?= h($activeChallenge->instruction) ?></h2>
                </div>
                <?= $this->Form->input('challenge_id', ['id'=>'challenge_id','value' =>$activeChallenge->id,'type'=>'hidden']); ?>
                <?= $this->Form->input('pageId', ['id'=>'page_id','value' =>$pageId,'type'=>'hidden']); ?>
                <?php
                if($activeChallenge->challenge_type_id == 1 || $activeChallenge->challenge_type_id == 4 || $activeChallenge->challenge_type_id == 5){
                    if(isset($activeChallenge->details['link'])) {
                        ?>
                        <div class="m-t-md text-center">
                            <iframe src="<?= $activeChallenge->details['link']?>" style = "width: 500px; height: 600px;"></iframe>
                        </div>
                        <?php } ?>
                        <div class="p-lg">
                            <h3 class="text-center">Question</h3>
                            <h4 class="text-center"><?= h($activeChallenge->details['statement']) ?></h4>
                            <?php
                            if($activeChallenge->details['question_type'] == "One-Word"){
                                ?>
                                <div class="form-group text required">
                                    <h3 for="name" class="col-sm-2 control-label">Your Response</h3>
                                    <div class="col-sm-10"><input type="text" id="name" maxlength="255" required="required" name="response" class="form-control">
                                    </div>
                                </div> 
                                <?php }else{ ?>
                                <div class=" col-sm-12 col-sm-offset-2">
                                    <div id="toastTypeGroup" class="form-group">      
                                        <?php foreach ($activeChallenge->details['option'] as $key => $value) : ?>
                                            <input type="radio" value="<?= $value ?>" name="radio" id ="radio<?= $key+1 ?>"><?= h($value)?><br>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            <?php }else if($activeChallenge->challenge_type_id == 2){ 
                                if(isset($activeChallenge->details['topic'])) {
                                    ?>
                                    <div class="m-t-md text-center">
                                        <h2><b><?= h($activeChallenge->details['topic']) ?></b></h2>
                                    </div>
                                    <div class="form-group text required m-t-md">
                                        <h3 class="col-sm-2 col-sm-offset-2">Your Response</h3>
                                        <div class="col-sm-6"><input type="text" id="name" maxlength="255" required="required" name="response" class="form-control">
                                        </div>
                                    </div> 
                                    <?php } }?>
                                    <div class="form-group">
                                        <div class="col-sm-4 col-sm-offset-4 text-center">
                                            <input type="button" id="submitResponse" value="Submit" name="submit" class = "btn btn-primary" >
                                            <input type="button" value="Cancel" name="cancel" class = "btn btn-danger">
                                        </div>
                                    </div>
                                </div>
                                <div id = "afterResponse" style="display: none;">
                                    <div class="m-t-md text-center">
                                        <h2 class="text-center"><b> Your Response has been successfully submitted.<br> Result will be available on <?= $challengeEndTime ?>.</b></h2>
                                    </div>
                                    <div class="fb-share-button text-center m-t-md" data-href="<?= $activeChallenge->url ?>" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore btn btn-xs btn-success" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?= $activeChallenge->encodeUrl ?>&amp;src=sdkpreparse">Share</a></div> 
                                </div>
                            </div>
                            <?= $this->Form->end() ?>
                            <!-- </div> -->
                        </div>
                    </div>
                    <script type="text/javascript">

                        $('#submitResponse').on('click',function(){
                            
                            var challengeId = $('#challenge_id').val();
                            var value = $('#name').val();
                            if(value.length <=0 ){
                                return false;
                            }

                            xyz(challengeId, value);
                        });

                        function xyz(challengeId, value){
                            swal({ title: 'Enter your Buzzydoc Details',
                               html: 
                               '<input type = "radio" id="swal-input1" value="username" name="username" checked="checked">UserName'  +  '<input type = "radio" id="swal-input2" value="card_number" name="username">CardNo.',
                               input: 'text',
                               inputValidator: function (value) {
                                return new Promise(function (resolve, reject) {
                                  if (value) {
                                    resolve()
                                } else {
                                    reject('Enter your details please!')
                                }
                            })
                            } 
                        }).then(function(identifierValue){
                            var identifierType = $('input[name=username]:checked' ).val();
                            response(identifierValue, identifierType, challengeId, value);
                        });
                    }

                    function response(identifierValue, identifierType, challengeId, value){
                        var host = $('#baseUrl').val();
                        var data = [];
                        data.push({
                            'challenge_id' : challengeId,
                            'response' : value,
                            'identifier_type' : identifierType,
                            'identifier_value' : identifierValue,
                            'p' : $('#page_id').val()

                        });
                        $.ajax({
                            method: "POST",
                            url : host + "api/userChallengeResponses/add",
                            data : {'data':data[0]}
                        })
                        .success(function(response){
                 // window.location.href = redirectUrl;
                 swal({
                    title : response.response.message,
                    type : 'success',
                    showConfirmButton : true
                });
                 console.log('after success');   
                 console.log(response.response);
                 $(" #deleteData").remove();
                 $(" #afterResponse").show();

             });
                    }



                </script>