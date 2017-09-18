<div class="row">
<div class="col-lg-12">
        <div class="ibox-content">
        <div class="row">
            <div class="m-t-md">
                <div class="p-lg ">
                <img src="<?= $activeChallenge->image_url ?>" class = "img-responsive img-shadow"/>
                </div>
            </div>
            <div class="m-t-md text-center">
                    <h1>Winner of Challenge <?= h($activeChallenge->name) ?></h1>
            </div>
            <div class="m-t-md text-center">
                    <h2><?= h($challengeWinner->identifier_value) ?></h2>
            </div>
        </div>
        </div>
    </div>
</div>
<!-- <script type="text/javascript">
    function popUp(){
        var data = [];
        var host = $('#baseUrl').val();
        var challengeId = $('#challenge_id').val();
        if($( 'input[name=radio]:checked' ).val()){
            var value = $( 'input[name=radio]:checked' ).val();
        }else if($('#name').val()){
            var value = $('#name').val();
        }
        xyz(challengeId, value);

        function xyz(challengeId, value){
            swal({ title: 'Enter your Buzzydoc Details',
               html: 
               '<input type = "radio" id="swal-input1" value="username" name="username">UserName'  +  '<input type = "radio" id="swal-input2" value="card_number" name="username">CardNo.',
               input: 'text' 
            }).then(function(identifierValue){
                var identifierType = $('input[name=username]:checked' ).val();
                response(identifierValue, identifierType, challengeId, value);
            });
        }
            
        function response(identifierValue, identifierType, challengeId, value){
            console.log('here');
            data.push({
                'challenge_id' : challengeId,
                'response' : value,
                'identifier_type' : identifierType,
                'identifier_value' : identifierValue,
                'fb_page_id' : 3

            });
            $.ajax({
                method: "POST",
                url : host + "api/userChallengeResponses/add",
                data : {'data':data[0]}
            })
            .success(function(response){
                console.log(response);
                console.log('sunno');
                swal({
                title: response.response.message,
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#A7D5EA",
                confirmButtonText: "Okay!"
            });
            });
        }
    }
        

</script> -->