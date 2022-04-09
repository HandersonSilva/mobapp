export const factoryObject = (reference) => {

    let obj = {}
    let checked
    let valueCheck
    
    document.querySelectorAll(`${reference} input`).forEach((e, i)=>{
        // console.log(indexName)
        if(e.getAttribute('type') == 'radio' && e.checked ){
            checked = e.getAttribute('name')
            valueCheck = e.value;
        }else if(!(e.getAttribute('type') == 'radio' && e.checked)){
            obj[e.getAttribute('name')] = e.value
        }

    });

    (checked != null || checked != undefined ) ? obj[checked] = valueCheck : null

    return new Promise((resolve, reject) => {
        resolve(obj);
    })
}
