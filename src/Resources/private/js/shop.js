import './product-variant-auto-complete';

document.addEventListener('DOMContentLoaded', () => {
  $('.sylius-autocomplete.ui.fluid.search.selection.dropdown').productVariantAutoComplete();
  initDropDownSyliusAutocomplete();
});


const initDropDownSyliusAutocomplete = () => {
  const targetNode       = document.querySelector("form.ui.loadable.form div[data-form-collection='list']");
  const config           = { childList: true };
  const observerRefresh  = new MutationObserver((e) => {
    e.forEach(({target}) => {
      var target = target.children.item((target.children.length -1));
      $(target).find('.sylius-autocomplete.ui.fluid.search.selection.dropdown').productVariantAutoComplete();
    })
  });
  observerRefresh.observe(targetNode, config);
}
