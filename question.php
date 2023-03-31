<?php

include('header.php');

date_default_timezone_set("Asia/kolkata");
$x = date("d-M-Y  h:i A");

?>
<script>
    function preventBack() {
        window.history.forward();
    }

    setTimeout("preventBack()", 0);

    window.onunload = function() {
        null
    };
</script>
<script src="QuestionRender.js"></script>
<div class="container-fluid px-5">
    <p class="mt-5 question mx-5"></p>
    <div class="time" value="<?php echo $x ?>"></div>


    <div class="mt-5 ml-5">
        <div class="mt-3 answer_block">

        </div>

    </div>
    <div class="w-25 fixed-top bg-light p-3" id="slide" style="top:65px; height: 92vh; ">
        <button class="btn mt-1 attempt"></button>
        <button class="btn mt-1  unattempt"></button>
        <div class="questionList">

        </div>
    </div>
</div>

<div class="bottomNav">
    <div class="bg-secondary py-3 w-100 float-right px d-flex align-items-center justify-content-center mr-5 rounded" style="width:40%">
        <div class="h5 time_counter align-items-center pt-2 text-light text-center d-flex justify-content-center" style="width:100px"></div>
        <button class="btn bg-light border px-4 mx-3" id="list">List</button>
        <button class="btn bg-light border px-4 mr-3 Previous">Previous</button>
        <span class="h5 text-light pt-3 pl-2 d-flex" style="width:100px">
            <div class="currentPage mr-3 h5 ">1</div> of <div class="totalPage ml-3 h5 ">11</div>
        </span>
        <button class="btn bg-light border px-4 ml-3 next">Next </button>
        <button class="btn bg-light border px-4 mx-3 endtest" data-toggle="modal" data-target="#mymodal">End Test</button>
    </div>
</div>

<div class="modal fade" id="mymodal" tabindex="-1" data role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="width:550px ; margin:auto">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-body text-center m-0">
                    <p class="mb-4"> This action will end your test. Do you want to proceed?</p>
                    <button class="btn mt-1"><span class="font-weight-bold items"></span></button>
                    <button class="btn mt-1 attempt"></button>
                    <button class="btn mt-1  unattempt"></button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close_modal" data-dismiss="modal">Close</button>
                <a href="resultPage.php" style="text-decoration: none;"><button type="button" class="btn btn-primary proceed">proceed</button></a>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#list").click(
            function() {
                $('#slide').toggleClass("slide");
            }
        )
        $("#slide").click(
            function() {
                $('#slide').blur().removeClass("slide");
            }
        )

        $("body").blur(function() {
            $("#slide").blur().removeClass("slide");
        });

        let minutes = 00;
        let seconds = 05;
        let countdown = setInterval(function() {
            if (seconds == 0) {
                minutes--;
                seconds = 59;
            } else {
                seconds--;
            }
            $('.time_counter').html(minutes + "m " + seconds + "s");
            if (minutes == 0 && seconds == 0) {
                clearInterval(countdown);
                $(".proceed").click();
            }
        }, 1000);
    });

    $.getJSON('question.json', function(data) {

        let arr = [];
        let arr2 = [];

        function loadoption(ind = 0) {
            if (ind == 0) {
                $('.Previous').prop("disabled", true);
            } else if (ind == data.length - 1) {
                $('.next').prop("disabled", true);
            } else {
                $('.Previous').prop("disabled", false);
                $('.next').prop("disabled", false);
            }

            let listdata = "";
            for (let i = 0; i < data.length; i++) {
                let sideQuestion = data[i].snippet;
                if (i == ind) {
                    listdata += `<div class="w-100 side_list py-3 text-primary" val="${i}" style="cursor:pointer">${i+1+") "}${sideQuestion}</div>`;
                } else {
                    listdata += `<div class="w-100 side_list py-3" val="${i}" style="cursor:pointer">${i+1+") "}${sideQuestion}</div>`;
                }
            }
            $('.questionList').html(listdata);

            window.addEventListener('click', function(e) {
                let _opened = $('#slide').hasClass('slide');
                if (_opened === true && !document.getElementById('slide').contains(e.target) && !document.getElementById('list').contains(e.target)) {
                    $('#slide').toggleClass('slide');
                }
            });


            let length = questionrend(ind, data, 0);

            $(".mylabel").click(function(e) {
                arr[ind] = $(e.target).attr('value');
                arr2[ind] = $(e.target).attr('option');
                test();
            })

            sessionStorage.setItem("optionInd", JSON.stringify(arr2));
            sessionStorage.setItem("items", JSON.stringify(arr));

            let retString = sessionStorage.getItem("optionInd")
            let retArray = JSON.parse(retString)
            let optind = document.querySelectorAll('.mylabel')
            for (let i = 0; i < length; i++) {
                if (retArray[ind] == i) {
                    optind[i].setAttribute('checked', true);
                }
            }

            function test() {
                window.sessionStorage.setItem("optionInd", JSON.stringify(arr2));


                let items = `<i class="fa-solid fa-list"></i> ${data.length} Items</span>`;
                $('.items').html(items);

                window.sessionStorage.setItem("items", JSON.stringify(arr));
                let storedArray = JSON.parse(sessionStorage.getItem("items"));
                let Attemped = storedArray.filter(function(value) {

                    if (value != null) {
                        return value;
                    }

                })

                let attemp = `<span class="font-weight-bold"><i class="fa-solid fa-eye"></i></i> ${Attemped.length} Attempted</span>`;
                $('.attempt').html(attemp);

                let unattemp = `<span class="font-weight-bold"><i class="fa-solid fa-eye-slash"></i></i> ${data.length-Attemped.length} Unattempted</span>`;
                $('.unattempt').html(unattemp);

                let resultdata = [];
                resultdata.push(data.length);
                resultdata.push(Attemped.length);
                resultdata.push($(".time").attr("value"));

                $(".proceed").click(function() {
                    window.sessionStorage.setItem("resultdata", JSON.stringify(resultdata));
                })
            }

            test();

            $(".endtest").click(function() {
                test();
            })
        }

        let tabindex = 0;
        if (tabindex == 0) {
            loadoption();
            $('.currentPage').text(tabindex + 1);
        }

        $("body").click(function(e) {
            if (e.target.classList.contains('side_list')) {
                index = $(e.target).attr('val');
                console.log(index);
                loadoption(index);
                tabindex = index;
                $('.currentPage').text(parseInt(tabindex) + 1);
            }
        })

        $('.totalPage').text(data.length);

        $('.Previous').click(function() {
            if (tabindex > 0) {
                tabindex--;
                loadoption(tabindex);
                $('.currentPage').text(tabindex + 1);
            }
        })

        $('.next').click(function() {
            if (tabindex < data.length - 1) {
                tabindex++;
                loadoption(tabindex);
                $('.currentPage').text(tabindex + 1);
            }
        })
    });
</script>






<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>


</body>

</html>