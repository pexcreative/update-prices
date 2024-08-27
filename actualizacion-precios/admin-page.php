<div class="wrap">
    <h1>Actualización de precios by Pex</h1>
    <form id="apbp-update-prices-form">
        <table class="form-table">
            <tr>
                <th scope="row"><label for="percentage">Porcentaje de actualización</label></th>
                <td>
					<input type="number" name="percentage" id="percentage" step="0.01" required min="-100" max="1000">
                    <p class="description">Ingrese un número positivo para aumentar los precios o negativo para disminuirlos.</p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="exclude_products">Excluir productos (IDs)</label></th>
                <td>
                    <input type="text" name="exclude_products" id="exclude_products">
                    <p class="description">Ingrese los IDs de los productos a excluir, separados por comas.</p>
                </td>
            </tr>
        </table>
        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button button-primary" value="Actualizar precios">
        </p>
    </form>
    <div id="apbp-progress-bar" style="display: none;">
        <div class="progress-bar"></div>
    </div>
    <div id="apbp-result-message"></div>
</div>