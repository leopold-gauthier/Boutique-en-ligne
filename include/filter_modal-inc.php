<div class="modal fade" id="myModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Filtrer les données</h5>
            </div>
            <div class="modal-body">
                <!-- Ajoutez ici les éléments de votre formulaire de filtrage -->
                <form>
                    <div class="form-group">
                        <label for="critere">Critère de filtrage :</label>
                        <select class="form-control" id="critere">
                            <option value="">Aucun</option>
                            <option value="option1">Option 1</option>
                            <option value="option2">Option 2</option>
                            <option value="option3">Option 3</option>
                        </select>
                    </div>
                    <!-- Ajoutez d'autres éléments de formulaire si nécessaire -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="filtrerDonnees()">Filtrer</button>
            </div>
        </div>
    </div>
</div>