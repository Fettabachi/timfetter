class DeviceDetection {
    constructor() {
        this.deviceDetection();
    }

    deviceDetection() {
        // Copyright 2016 - ScientiaMobile, Inc., Reston, VA
        // WURFL Device Detection
        // Terms of service:
        // http://web.wurfl.io/license

        if (WURFL.is_mobile === true && WURFL.form_factor === "Smartphone") {
            // targetSmartPhoneDevices();
            let deviceName = String(WURFL.complete_device_name);
            deviceName = deviceName.replace(/\s+/g, '-').toLowerCase();
            let formFactor = String(WURFL.form_factor);
            formFactor = formFactor.replace(/\s+/g, '-').toLowerCase();

            console.log(deviceName);
            console.log(formFactor);
            document.body.classList.add(deviceName, formFactor);
        }
    }
}

export default DeviceDetection;
