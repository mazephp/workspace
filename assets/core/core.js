function loadFile(filename,filetype)
{
    if(filetype == "js")
    {
        var fileref = document.createElement('script');
        fileref.setAttribute("type","text/javascript");
        fileref.setAttribute("src",filename + '.' + filetype);
    }
    else if(filetype == "css")
    {
        var fileref = document.createElement('link');
        fileref.setAttribute("rel","stylesheet");
        fileref.setAttribute("type","text/css");
        fileref.setAttribute("href",filename + '.' + filetype);
    }
    if(typeof fileref != "undefined")
    {
        document.getElementsByTagName("head")[0].appendChild(fileref);
    }
}

var include_index = 0;

function include()
{
    var self = $(".include").eq(include_index);
    var system  = self.attr('system');
    var path    = self.attr('path');
    var name    = self.attr('file');

    var file = '';
    if(path) file = path;
    if(system) file = file + '/' + system;
    
    file += name + '.html';

    $.ajax(
    {
        url: file,
        async: false,
        success: function (result)
        {
            document.write(result);
        }
    });
    include_index++;
}

//loadFile('../../core/bootstrap/bootstrap.min', 'js');
//loadFile('../../core/bootstrap/bootstrap.min', 'css');