/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import 'semantic-ui-css/components/dropdown';
import 'semantic-ui-css/components/api';
import 'semantic-ui-css/components/transition';
import $ from 'jquery';

$.fn.extend({
  productVariantAutoComplete() {
    this.each((idx, el) => {
      const element           = $(el);
      const criteriaName      = element.data('criteria-name');
      const choiceName        = element.data('choice-name');
      const choiceValue       = element.data('choice-value');
      const autocompleteValue = element.find('input.autocomplete').val();
      const loadForEditUrl    = element.data('load-edit-url');
      const menuElement       = element.find('div.menu');
      const container         = element.closest('.ui.stackable.grid').find('#details-container-variant');
      initQuantityEventListener(el);
      element.dropdown({
        delay: {
          search: 250,
        },
        forceSelection: false,
        apiSettings: {
          dataType: 'JSON',
          cache: false,
          type: 'imageResult',
          beforeSend(settings) {
            /* eslint-disable-next-line no-param-reassign */
            settings.data[criteriaName] = settings.urlData.query;

            return settings;
          },
          onResponse(response) {
            let results = response.map(item => ({
              name: item[choiceName],
              value: item[choiceValue],
              image: item['image'],
              price: item['price'],
              slug: item['slug'],
            }));
            return {
              success: true,
              results: results,
            };
          },
          onSuccess(response) {
            menuElement.empty();
            response.results.forEach((item) => {
              menuElement.append((
                $(`<div class="item" data-value="${item['value']}" data-slug="${item['slug']}">
                    <img class="ui avatar image" src="${item['image']}">
                    <span class="description">${item['price']}</span>
                    <span class="text" >${item['name']}</span>
                  </div>`)
              ));
            });
            element.dropdown('refresh');
            element.dropdown('set selected', element.find('input.autocomplete').val().split(',').filter(String));
            element.dropdown('show');
          },
        },
        onChange(addedValue, addedText, $addedChoice) {
          const priceTrans            = container.attr('data-price-trans');
          const quantityInput         = element.closest('.ui.stackable.grid').find(':input[type="number"]');
          const quantity              = quantityInput.val();
          const row                   = $('<div>' + addedText + '</div>')
          const image                 = row.find('img.ui.avatar.image').attr('src');
          const unitPriceAndCurrency  = row.find('span.description').html();
          const unitPrice             = unitPriceAndCurrency.match('[+-]?[0-9]+([.][0-9]+)?([eE][+-]?[0-9]+)?').shift()
          const currencySymbol        = unitPriceAndCurrency.replace(unitPrice, '')
          const pricing               = !!quantity ? (parseInt(quantity) * parseFloat(unitPrice)).toFixed(2) : 0;

          container.empty();
          container.append($('' +
            '<div class="field" data-image="' + image + '" data-currency-symbol="' + currencySymbol + '" data-unit-price="' + unitPrice + '">' +
              '<label>' + priceTrans + '</label>' +
              '<span>' + currencySymbol + pricing + '</span>' +
            '</div>')
          )
        },
        onRemove(removedValue, removedText, $removedChoice) {
          container.empty();
        }
      });
    });
  },
});

const initQuantityEventListener = (ele) => {
  const container = ele.closest('.ui.stackable.grid');
  const input     = container.querySelector('input[type="number"]')
  if (!input) return;
  input.addEventListener('change', ({currentTarget}) => {
    const fieldContainer = container.querySelector('#details-container-variant .field')

    if (!fieldContainer) return

    const {unitPrice, currencySymbol} = fieldContainer.dataset

    if (!unitPrice || !currencySymbol) return;

    debugger
    const pricing  = parseFloat(parseInt(currentTarget.value) * unitPrice).toFixed(2);
    const span     = document.createElement('span')
    span.innerHTML = currencySymbol + pricing

    fieldContainer.querySelector('span').remove()
    fieldContainer.append(span)
  })
}
