crud.field('access_only_at_the_user_company_level').onChange(function (field) {
    crud.field('companies').show(field.value == 0);
}).change();
