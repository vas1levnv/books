$(document).ready(function () {
    let ajaxData = {}
    $("#target").keyup(function () {
        ajaxData.name = $("#target").val();
        getList();
    });

    $("input[name=genres]").on("change", function () {
            let checkboxesGenres = []
            $('input:checkbox:checked[name=genres]').each(function () {
                checkboxesGenres.push(this.value);
            });
            let genres = checkboxesGenres;
            checkboxesGenres = [];
            ajaxData.genres = genres
            getList();
        }
    );

    $("input[name=authors]").on("change", function () {
        let checkboxesAuthors = [];
        $('input:checkbox:checked[name=authors]').each(function () {
            checkboxesAuthors.push(this.value);
        });
        let authors = checkboxesAuthors;
        checkboxesAuthors = [];
        ajaxData.authors = authors
        getList();
    });

    function getList() {
        $.ajax({
            type: "GET",
            url: "filter.php",
            data: ajaxData,
            success: function (data) {
                data = JSON.parse(data);
                if (data[0].images) {
                    $("#books").empty();
                    data.forEach(function (item) {
                        $("#books").append("<div class=\"row p-5\">\n" +
                            "                <div class=\"col-lg-4\">\n" +
                            "                    <img src=\" " + item.images + "\">\n" +
                            "                </div>\n" +
                            "                <div class=\"col-lg-8\">\n" +
                            "                    <div class=\"d-flex justify-content-between align-items-center\">\n" +
                            "                        <h4>Название книги</h4>\n" +
                            "                        <div>" + item.name + "\n" +
                            "                        </div>\n" +
                            "                    </div>\n" +
                            "                    <div class=\"d-flex justify-content-between align-items-center\">\n" +
                            "                        <h4>Жанр</h4>\n" +
                            "                        <div>" + item.genre + "\n" +
                            "                        </div>\n" +
                            "                    </div>\n" +
                            "                    <div class=\"d-flex justify-content-between align-items-center\">\n" +
                            "                        <h4>Автор</h4>\n" +
                            "                        <div>" + item.author + "\n" +
                            "                        </div>\n" +
                            "                    </div>\n" +
                            "                    <div class=\"d-flex justify-content-between align-items-center\">\n" +
                            "                        <h4 class=\"me-5\">Описание</h4>\n" +
                            "                        <div class=\"text-end\">" + item.description + "</div>\n" +
                            "                    </div>\n" +
                            "                </div>\n" +
                            "            </div>");
                    })
                } else {
                    $("#books").empty();
                    alert(data)
                }
            },
            error: function () {
                alert("fail");
            },
        })
    }
})