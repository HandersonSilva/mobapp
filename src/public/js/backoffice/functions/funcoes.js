import moneyMask from "./moneyMask";

export function setMoneyMask(inputs){
    moneyMask(inputs);
}

export function formatFloatBd(valor){
    return valor.replace("R$", "")
    .replace(".", "")
    .replace(",", ".")
    .trim();
}