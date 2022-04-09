const axios = require("axios").default;
import { _alert } from "./Alert";

export const sendFileImg = ({
    fileObject,
    nameFolder,
    urlPost,
    extraData = null,
    showAlert = false
}) => {
    nameFolder = nameFolder.replace(/ /g, "_");
    console.log("File:", fileObject);
    let data = new FormData();
    data.append("file", fileObject, fileObject.name);
    data.append(
        "name_folder",
        nameFolder.normalize("NFD").replace(/[\u0300-\u036f]/g, "")
    );
    if (extraData != null) {
        data.append("extra_data", extraData);
    }
    console.log("Data: ", data);
    let settings = { headers: { "content-type": "multipart/form-data" } };

    axios
        .post(urlPost, data, settings)
        .then(response => {
            console.log(response.status);
            if (response.status == 200 && showAlert) {
                _alert({
                    title: "Dados atualizados",
                    icon: "success",
                    confirmButtonText: "OK",
                    callback: function() {
                        window.location = window.location.href;
                    }
                });
            }
        })
        .catch(response => {
            console.log(response);
        });
};
