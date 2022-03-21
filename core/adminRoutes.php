<?php

// Array de rotas
$routes = [
    "home" => "adminController@index",

    // Login
    "signin" => "authController@signIn",
    "signinsubmit" => "authController@signInSubmit",
    "logout" => "authController@LogoutAdmin",

    // Slides
    "sliders" => "slidersController@sliders",
    // Adicionar slide
    "newslide" => "slidersController@newslide",
    "newslideSubmit" => "slidersController@newslideSubmit",
    // Editar slide
    "getSlidebyId" => "slidersController@getSlidebyId",
    "editslideSubmit" => "slidersController@editslideSubmit",
    // Deletar slide
    "deleteSlide" => "slidersController@deleteSlide",

    // Serviços
    "services" => "serviceController@services",
    // Adicionar serviço
    "newservice" => "serviceController@newservice",
    "newserviceSubmit" => "serviceController@newserviceSubmit",
    // Editar serviço
    "getServiceById" => "serviceController@getServiceById",
    "editserviceSubmit" => "serviceController@editServiceSubmit",
    // Deletar serviço
    "deleteService" => "serviceController@deleteService",

    // Testemunhas
    "testimonials" => "testimonialController@testimonialsList",
    // Adicionar testemunha
    "newtestimonial" => "testimonialController@newtestimonial",
    "newtestimonialSubmit" => "testimonialController@newtestimonialSubmit",
    // Editar testemunha
    "getTestimonialById" => "testimonialController@getTestimonialById",
    "edittimonialSubmit" => "testimonialController@editTestimonial",
    // Deletar testemunha
    "deleteTestimonial" => "testimonialController@deleteTestimonial",

    // Usuários
    "users" => "userController@users",
    "updateUser" => "userController@updateUser",
    // Adicionar usuário
    "newuser" => "userController@newuser",
    "newuserSubmit" => "userController@newuserSubmit",

    // Configurações
    "config" => "settingsController@config",
    // Atualizar configurações
    "updateConfig" => "settingsController@updateConfig",

    // Noticias [blog]
    "notices" => "blogController@blog",
    "singleNotice" => "blogController@singleNotice",
    "newCategory" => "blogController@newCategory",
    "newCategorySubmit" => "blogController@newCategorySubmit",
    // Atualizar categoria
    "getCategoryById" => "blogController@getCategoryById",
    "editcategorySubmit" => "blogController@editcategorySubmit",
    // Deletar categoria
    "deleteCategory" => "blogController@deleteCategory",

    // Adicionar post
    "newPost" => "blogController@newPost",
    "newPostSubmit" => "blogController@newPostSubmit",
    // Editar post
    "editPostSubmit" => "blogController@editPostSubmit",
    // Editar thumbnail
    "updateThumbandCategory" => "blogController@updateThumbandCategory",
    // Deletar post
    "deletePost" => "blogController@deletePost",

    // Clientes
    "clients" => "clientsController@clients",
    // Adicionar clientes
    "newClient" => "clientsController@newClient",
    "newClientSubmit" => "clientsController@newClientSubmit",
    // Editar client
    "editClient" => "clientsController@editClientForm",
    "editClientSubmit" => "clientsController@editClientSubmit",
    // Deletar clientes
    "deleteClient" => "clientsController@deleteClient",
    // Pesquisar cliente
    "searchClient" => "clientsController@searchClient",

    // Financeiro
    "financial" => "financialController@financial",
    "addPaymentClientSubmit" => "financialController@addPaymentClient",
    // Alterar status de pagamento para pago
    "alterStatusPaid" => "financialController@alterStatusPaid",
    "alterStatus" => "financialController@alterStatus",
    
    // PDF
    "pdf" => "financialController@pdf",

    // Email pagamento pendende
    "sendEmailPaymentPending" => "financialController@sendEmailPaymentPending",

    // Produtos
    "products" => "productsController@index",
    // Adicionar produtos
    "newProduct" => "productsController@newProduct",
    "newProductSubmit" => "productsController@productSubmit",
    // Editar produto
    "editProduct" => "productsController@editProduct",
    "editProductSubmit" => "productsController@editProductSubmit",
    // Adicionar imagens
    "addImagesProduct" => "productsController@addImages",
    // Deletar uma imagem
    "imageDelete" => "productsController@deleteImageSingle",
    // Deletar produto
    "delProduct" => "productsController@delProduct",
    // Pesquisar produto
    "searchProduct" => "productsController@searchProduct",
    // Produtos em falta ou acabando
    "showProducts" => "productsController@showProductsEndingOrZero",

    // Gestão de imóveis
    "property" => "propertyController@property",
    // Adicionar imóvel/propriedade
    "newProperty" => "propertyController@newProperty",
    "propertySubmit" => "propertyController@submitProperty",
    // Editar imóvel/propriedade
    "editProperty" => "propertyController@editProperty",
    "editPropertySubmit" => "propertyController@editSubmit",
    // Deletar propriedade
    "delProperty" => "propertyController@delete",
    // Pesquisar propriedade
    "searchProperty" => "propertyController@searchProperty",
    
    // Adicionar imóvel a propriedade
    "newHousingSubmit" => "housingController@newHousingSubmit",
    "showHousing" => "housingController@show",
    // Atualizar imóvel
    "updateHousingSubmit" => "housingController@updateHousingSubmit",
    // Deletar uma imagem do imóvel, imagem vem pela query string
    "delHousingImage" => "housingController@delSingleImageHousing",
    // Adicionar novas imagens ao imóvel
    "newImagesHousing" => "housingController@newImagesHousing",
    // Deletar um imóvel
    "deleteHousing" => "housingController@deleteHousing",

    // Calendário
    "calendar" => "calendarController@index",
    // Ajax methods
    "getTodosByDate" => "calendarController@getTodosByDate",

    "newTodo" => "calendarController@newTodo",
];

// Action padrão
$action = "home";

// Verificar se existe uma url na query string
if(isset($_GET["url"])) {
    // Verificar se existe a url no array de rotas
    if(!key_exists($_GET["url"], $routes)) {
        $action = "home";
    } else {
        $action = $_GET["url"];
    }
}

// Definindo as rotas
$parts = explode("@", $routes[$action]);
$controller = "core\\controllers\\admin\\".ucfirst($parts[0]);
$method = $parts[1];

$ctr = new $controller();
$ctr->$method();