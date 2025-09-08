if (crud.field('access_only_at_the_user_company_level').value == 0) {
    crud.field('companies').show(false);
}

crud.field('access_only_at_the_user_company_level').onChange(function (field) {
    crud.field('companies').show(field.value == 1);
}).change();
