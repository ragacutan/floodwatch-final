function initializeDropdowns(data) {
    const regionDropdown = document.getElementById("region");
    const provinceDropdown = document.getElementById("province");
    const municipalityDropdown = document.getElementById("municipality");
    const barangayDropdown = document.getElementById("barangay");

    // Populate the region dropdown
    for (const regionCode in data) {
        const regionOption = document.createElement("option");
        regionOption.value = regionCode;
        regionOption.textContent = data[regionCode].region_name;
        regionDropdown.appendChild(regionOption);
    }

    // Handle region selection change
    regionDropdown.addEventListener("change", function () {
        const selectedRegionCode = regionDropdown.value;
        provinceDropdown.innerHTML = "<option value=''>Select Province</option>";
        municipalityDropdown.innerHTML = "<option value=''>Select Municipality</option>";
        barangayDropdown.innerHTML = "<option value=''>Select Barangay</option>";

        if (selectedRegionCode) {
            const regionData = data[selectedRegionCode];
            for (const provinceName in regionData.province_list) {
                const provinceOption = document.createElement("option");
                provinceOption.value = provinceName;
                provinceOption.textContent = provinceName;
                provinceDropdown.appendChild(provinceOption);
            }

            provinceDropdown.disabled = false;
        } else {
            provinceDropdown.disabled = true;
        }
    });

    // Handle province selection change
    provinceDropdown.addEventListener("change", function () {
        const selectedRegionCode = regionDropdown.value;
        const selectedProvinceName = provinceDropdown.value;
        municipalityDropdown.innerHTML = "<option value=''>Select Municipality</option>";
        barangayDropdown.innerHTML = "<option value=''>Select Barangay</option>";

        if (selectedRegionCode && selectedProvinceName) {
            const provinceData = data[selectedRegionCode].province_list[selectedProvinceName];
            for (const municipalityName in provinceData.municipality_list) {
                const municipalityOption = document.createElement("option");
                municipalityOption.value = municipalityName;
                municipalityOption.textContent = municipalityName;
                municipalityDropdown.appendChild(municipalityOption);
            }

            municipalityDropdown.disabled = false;
        } else {
            municipalityDropdown.disabled = true;
        }
    });

    // Handle municipality selection change
    municipalityDropdown.addEventListener("change", function () {
        const selectedRegionCode = regionDropdown.value;
        const selectedProvinceName = provinceDropdown.value;
        const selectedMunicipalityName = municipalityDropdown.value;
        barangayDropdown.innerHTML = "<option value=''>Select Barangay</option>";

        if (selectedRegionCode && selectedProvinceName && selectedMunicipalityName) {
            const barangayData = data[selectedRegionCode].province_list[selectedProvinceName].municipality_list[selectedMunicipalityName];
            for (const barangayName of barangayData.barangay_list) {
                const barangayOption = document.createElement("option");
                barangayOption.value = barangayName;
                barangayOption.textContent = barangayName;
                barangayDropdown.appendChild(barangayOption);
            }

            barangayDropdown.disabled = false;
        } else {
            barangayDropdown.disabled = true;
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    // Data will be loaded via PHP, so we call initializeDropdowns here.
    // The addresses data is passed as an argument.
});
