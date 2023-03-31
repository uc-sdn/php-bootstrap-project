function questionrend(num, data, test) {
    var questionAnswers = JSON.parse(data[num].content_text);
    $('.question').text(parseInt(num) + 1 + ") " + questionAnswers.question);
    if (test == 1) {
        $('.explanation').html(questionAnswers.explanation);
    }
    let answer = ``;
    for (let i = 0; i < questionAnswers['answers'].length; i++) {
        answer += `
        <label class="h5 w-75 ml-2 d-flex answer_block">
        <input type="radio" name="click" class="mylabel" questionId="${data[num].content_id}" value="${questionAnswers['answers'][i]['is_correct']}" option="${i}">
        <div class="ml-3 ans_option">${questionAnswers['answers'][i]['answer']}</div>
    </label>
        `;
        $('.answer_block').html(answer)
    }
    return questionAnswers['answers'].length;
}