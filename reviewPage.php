<?php

include('header.php');
?>

<style>
    .answer_block {
        pointer-events: none;
    }
    .a_next,
    .a_previous {
        text-decoration: none;
    }
</style>
<?php
$no = $_GET['question_id'];
?>
<div class="container-fluid px-5 mb-2 w-100">

    <div class="btn p-4 text-light d-flex justify-content-center">
        <a href="#result" style="text-decoration: none;">
            <div class="alert"><i class="fa-solid mr-2 "></i></div>
    </div></a>
</div>

<p class=" question mx-5"></p>

<div class="mt-5 ml-5">
    <div class="mt-3 answer_block"></div>
</div>

<div class="w-25 fixed-top bg-light p-3" id="slide" style="top:65px; height: 92vh; ">
</div>

<div class="bottomNav">
    <div class="bg-secondary py-3 float-right px d-flex align-items-center justify-content-center mr-5 rounded" style="width:85%">
        <button class="btn bg-light border px-4 mx-3" id="list">List</button>
        <a class="a_previous"><button class="btn bg-light border px-4 mr-3 Previous">Previous</button></a>
        <span class="h5 text-light pt-3 pl-2 d-flex" style="width:100px">
            <div class="currentPage mr-3 h5 "><?php echo $no + 1 ?></div> of <div class="totalPage ml-3 h5 ">11</div>
        </span>
        <a class="a_next"><button class="btn bg-light border px-4 ml-3 next">Next </button></a>
        <a href="resultPage.php"><button class="btn bg-light border px-4 mx-3 resultPage">result page</button></a>
    </div>
</div>



<div class="m-5 px-5" id="result">
    <h5 class="border-bottom pb-2 pt-5">Explanation</h5>
    <div class="explanation">
    </div>
</div>


<script src="jquery.js"></script>
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

        $(".fixed-top").blur(function() {
            $("#slide").blur().removeClass("slide");
        });
    });

    let queries = {};
    $.each(document.location.search.substr(1).split('&'), function(c, q) {
        let i = q.split('=');
        queries[i[0].toString()] = i[1].toString();
    });

    jsindex = Number(queries.question_id);




    $.getJSON('question.json', function(data) {


        let listdata = ``;
            for (let i = 0; i < data.length; i++) {
                let sideQuestion = data[i].snippet;
                if(i==jsindex)
                {
                    listdata += `<a class="slideLink"  style="text-decoration: none; color:black"><div class="w-100 side_list py-3 text-primary" val="${i}" style="cursor:pointer">${i+1+") "}${sideQuestion}</div></a>`;
                }
                else{
                    listdata += `<a class="slideLink"  style="text-decoration: none; color:black"><div class="w-100 side_list py-3" val="${i}" style="cursor:pointer">${i+1+") "}${sideQuestion}</div></a>`;
                }
            }
            $('#slide').html(listdata);

            window.addEventListener('click', function(e) {
                let _opened = $('#slide').hasClass('slide');

                if (_opened === true && !document.getElementById('slide').contains(e.target) && !document.getElementById('list').contains(e.target)) {
                    $('#slide').toggleClass('slide');
                }
            });

        let questionAnswers = JSON.parse(data[jsindex].content_text);
        $('.question').text(jsindex + 1 + ") " + questionAnswers.question);
        $('.explanation').html(questionAnswers.explanation);
        let answer = ``;
        for (let i = 0; i < questionAnswers['answers'].length; i++) {
            answer += `
            <label class="h5 w-75 ml-2 d-flex answer_block">
                <input type="radio" name="click" class="mylabel">
                <div class="ml-3 ans_option">${questionAnswers['answers'][i]['answer']}</div>
            </label>
                `;
            $('.answer_block').html(answer)
        }

        let correct_answers = [];
        let correct_index = [];
        for (let i = 0; i < data.length; i++) {
            questionAnswers = JSON.parse(data[i].content_text);


            for (let j = 0; j < questionAnswers.answers.length; j++) {
                if (questionAnswers.answers[j].is_correct == 1) {
                    correct_answers.push(questionAnswers.answers[j].is_correct);
                    correct_index.push(j);
                }
            }
        }

        let storedArray = JSON.parse(sessionStorage.getItem("items"));
        let optionInd = JSON.parse(sessionStorage.getItem("optionInd"));

        if (correct_answers[jsindex] == storedArray[jsindex]) {
            $('.alert').append("correct");
            $('.fa-solid').addClass("fa-check");
            $('.alert').addClass("alert-success");
        } else if (null == storedArray[jsindex]) {
            $('.alert').append("unattempted");
            $('.fa-solid').addClass("fa-eye-slash");
            $('.alert').addClass("alert-secondary");
        } else {
            $('.alert').append("incorrect");
            $('.fa-solid').addClass("fa-xmark");
            $('.alert').addClass("alert-danger");
        }

        let optind = document.querySelectorAll('.mylabel');
        let ans_option = document.querySelectorAll('.ans_option');

        for (let i = 0; i < 4; i++) {
            if (optionInd[jsindex] == i) {

                optind[i].setAttribute('checked', true);
                if (optionInd[jsindex] == correct_index[jsindex]) {
                    ans_option[i].classList.add('text-success');
                } else {
                    ans_option[i].classList.add('text-danger');
                    let correct_ind = correct_index[jsindex];
                    ans_option[correct_ind].classList.add('text-success');
                }
            }
        }

        let tabindex = jsindex;
        if (tabindex == 0) {
            $('.currentPage').text(jsindex + 1);

        }

        $(".side_list").click(function(e) {
            index = $(e.target).attr('val');
            $('.slideLink').attr('href', `reviewPage.php?question_id=${index}`)
        })

        $('.totalPage').text(data.length);

        $('.Previous').click(function() {
            if (tabindex > 0) {
                tabindex--;
                $('.a_previous').attr('href', `reviewPage.php?question_id=${tabindex}`)
            }
        })

        $('.next').click(function() {
            if (tabindex < data.length - 1) {
                tabindex++;
                $('.a_next').attr('href', `reviewPage.php?question_id=${tabindex}`)
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