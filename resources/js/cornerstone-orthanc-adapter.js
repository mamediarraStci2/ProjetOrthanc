// Adaptateur Cornerstone pour Orthanc
cornerstone.registerImageLoader('dicom', function(imageId) {
    const orthancInstanceId = imageId.replace('dicom://', '');
    
    const options = {
        // Vous pouvez ajouter des options supplémentaires ici
    };

    return new Promise((resolve, reject) => {
        // Faire une requête à notre endpoint pour récupérer l'image
        fetch(`/api/orthanc/instances/${orthancInstanceId}/preview`)
            .then(response => response.arrayBuffer())
            .then(arrayBuffer => {
                // Créer une image Cornerstone à partir des données
                const image = new Image();
                image.src = URL.createObjectURL(new Blob([arrayBuffer]));
                
                image.onload = () => {
                    const canvas = document.createElement('canvas');
                    canvas.width = image.width;
                    canvas.height = image.height;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(image, 0, 0);

                    const cornerstoneImage = {
                        imageId: imageId,
                        minPixelValue: 0,
                        maxPixelValue: 255,
                        slope: 1.0,
                        intercept: 0,
                        windowCenter: 127,
                        windowWidth: 256,
                        getPixelData: () => {
                            const imageData = ctx.getImageData(0, 0, image.width, image.height);
                            return imageData.data;
                        },
                        rows: image.height,
                        columns: image.width,
                        height: image.height,
                        width: image.width,
                        color: true,
                        rgba: true,
                        columnPixelSpacing: 1,
                        rowPixelSpacing: 1,
                        sizeInBytes: image.width * image.height * 4
                    };

                    resolve(cornerstoneImage);
                };

                image.onerror = () => {
                    reject(new Error('Failed to load image'));
                };
            })
            .catch(error => {
                reject(error);
            });
    });
}); 