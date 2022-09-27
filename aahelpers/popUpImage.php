<?php

echo '

    <!-- Modal edit/new photo-->
    <div class="modal fade" id="editPhotoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="photoModalModalHeader" class="photoModalModalHeaderXX">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form id="editPhotoForm">

                        <div id="editSection">
                            <div id="tabs">
                                <ul>
                                    <li><a id="photoModalTabImage" href="#image">xxx</a></li>
                                    <li><a id="photoModalTabMetaData" href="#metaData">xxx</a></li>
                                </ul>
                                <div id="image">
                                    <input id="photoModalSelectImage" type="file" accept="image/*" name="selectImage">
                                    <div id="divReCrop">
                                        <button id="btnPhotoModalReCrop" type="button" class="btn btn-outline-primary">Re-crop</button>
                                    </div>
                                    <div id="photoModalImgPreviewWrapper" class="mt-1">
                                        <img id="photoModalImgPreviewUpload" src="" style="max-width: 100%" alt="pre-view">
                                    </div>

                                    <div id="buttonsWrapper" class="mg-hide-element">
                                        <div id="grpPhotoModalEditButtons" class="btn-group btn-group-sm mt-t" role="group">
                                            <button id="btnPhotoModalStartCropper" title="Re-crop" class="image-edit-btn"><i class="fa fa-crop"></i></button>
                                            <button id="btnPhotoModalFlip" title="Flip image horizontally" class="image-edit-btn"><i class="fa fa-arrows-h"></i></button>
                                            <button id="btnPhotoModalRotate" title="Rotate 90 degree clockwise" class="image-edit-btn"><i class="fa fa-rotate-right"></i></button>
                                            <button id="btnPhotoModal32" type="button" title="Set crop ratio to 3:2" class="image-edit-btn"><i class="fa fa-picture-o"></i></button>
                                            <button id="btnPhotoModal11" type="button" title="Set crop ratio to 1:1" class="image-edit-btn"><i class="fa fa-square-o"></i></button>
                                            <button id="btnPhotoModalReset" type="button" title="Reset image and crop area" class="image-edit-btn"><i class="fa fa-refresh"></i></button>
                                        </div>
                                    </div>
                                    <div><small><span id="photoModalCropInfo"></span></small></div>
                                    <div><small><span id="photoModalCropWarning" class="text-danger"></span></small></div>
                                    
                                </div>

                                <div id="metaData">
                                    <div id="wait">

                                    </div>
                                    <div id="editForm" class="mb-3">
                                        <input id="currentImageId" type="text" hidden>
                                        <input id="currentMode" type="text" hidden>
                                        <input id="selectedKeywords" type="text" hidden>
                                        <input id="selectedTaxa" type="text" hidden>
                                        <div class="form-group">

                                            <label id="lblPhotoModalPerson" for="slctPhotoModalPerson"></label><br>
                                            <select id="slctPhotoModalPerson" name="fotograf" required class="form-select js-example-basic-single form-field" style="width: 75%">
                                            </select>
                                            <div class="text-danger"><small id="personPhotoModalWarningText"></small></div>
                                            <br/>
                                        </div>

                                        <div class="form-group">
                                            <label id="lblPhotoModalDateTaken" for="inpPhotoModalDateTaken">xxxx</label><br>
                                            <input id="inpPhotoModalDateTaken" type="text" name="dateTaken" class="form-control form-field" size="10" style="width: 75%">
                                            <div class="text-danger"><small id="datePhotoModalWarningText"></small></div>
                                            <br/>
                                        </div>

                                        <div class="form-group">
                                            <label id="lblPhotoModalTaxa" for="slctPhotoModalTaxa">xxxx</label><br>
                                            <select id="slctPhotoModalTaxa" class="form-select js-example-basic-single form-field" style="width: 75%">
                                            </select>
                                            <div class="text-danger"><small id="selectedTaxaPhotoModalWarningText"></small></div>
                                            <div>
                                                <ul id="selectedPhotoModalTaxa" class="mgUlInline">
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label id="lblPhotoModalKeywords" for="slctPhotoModalKeywords" >xxxx</label><br>
                                            <select id="slctPhotoModalKeywords" class="form-select js-example-basic-single form-field" style="width: 75%">
                                                //
                                            </select>
                                            <div class="text-danger"><small id="selectedKeywordsPhotoModalWarningText"></small></div>
                                            <div>
                                                <ul id="selectedPhotoModalKeywords" class="mgUlInline">

                                                </ul>
                                            </div>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label id="lblPhotoModalPlats" for="inpPhotoModalPlats">xxxx</label>
                                            <input id="inpPhotoModalPlats" type="text" name="plats" class="form-control form-field" size="50">
                                            <div class="text-danger"><small id="selectedPlacePhotoModalWarningText"></small></div>
                                            <br/>
                                        </div>

                                        <div class="form-group">
                                            <input id="cbPhotoModalPublished" type="checkbox" name="published" class="form-check-input form-field">
                                            <label id="lblPhotoModalPublished" for="cbPhotoModalPublished"></label>
                                            <p id="editInfo" class="mg-hide-element">xxxx</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button id="btnPhotoModalCancel" type="button" class="btn btn-secondary closeModalEditPhoto">XXyXX</button>
                    <button id="btnPhotoModalSave" type="button" class="btn btn-primary">XXXX</button>
                </div>
            </div>
        </div>
    </div>



';