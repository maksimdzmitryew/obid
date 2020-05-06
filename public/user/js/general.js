let b_load_more 		= false;
moment.locale(s_app_locale_code);

window.function_exists=function(function_name,scope){
	//Setting default scope of none is provided
	if(typeof scope === 'undefined') scope=window;
	//Checking if function name is defined
	if (typeof function_name === 'undefined')
		throw new error('You have to provide a valid function name!');
	//The type container
	var fn = (typeof scope[function_name]);
	//function type
	if (fn === 'function') return true;
	//function object type
	if (fn.indexOf('function') > -1) return true;
	return false;
}

function setPaginationData (total, start, limit)
{
    nav_container   = $('<div class="pagination justify-content-center">'),
    nav_holder      = $('.nav_pagination_wrap'),
    pages           = Math.ceil(total / limit),
    current         = start / limit + 1;
}

function setImage(item, type)
{
    var a_image = {
            name: 'no image',
            url: '/admin/images/no-image-logo.jpg',
            small_image_url: '/admin/images/no-image-logo.jpg'
        };
    if (typeof item.image !== 'object' || typeof item.image.url !== 'string')
        {
            item.image = a_image;
        }
    return item;
}

function setDate(item)
{
    item.date = moment(item.date).format('LLL');
    return item;
}

function setCategory(item)
{
    if (typeof item.category === 'string')
    {
        item.category = {'name': item.category};
    }
    return item;
}

function setUrl(item, type)
{
    if (typeof a_route_fe[type] == 'undefined') return item;

	item.url = a_route_fe[type];
    if (item.url.indexOf(':slug') > -1)
    {
        item.url = item.url.replace(':slug', item.slug);
    }
    if (item.url.indexOf(':festival') > -1// && typeof item.festival != 'undefined'
    	)
    {
        item.url = item.url.replace(':festival', item.festival.slug);
    }
    return item;
}

function getReplaceInTpl(i_type, entry)
{

    return $.tmpl
    (
        $('#div-tpl-' + i_type)
            .html()
            // TODO refactoring
            // 1) we need to hide the template's src="${img}" by commenting it output
            // 2) otherwise there will be 404 not found error in browser logs:
            // when the page first load into a browser
            // e.g. GET /poland/$%7Bimage%7D HTTP/1.1 404
            // ATTN: single occurence replacement
            //.replace('<!--', '')
            //.replace('-->', '')
            // ATTN: all occurences replacement
            .replace(/<!--/g, '')
            .replace(/-->/g, '')
        , entry
    );
}

function appendToTpl(i_type, entry)
{
	//TODO
}
