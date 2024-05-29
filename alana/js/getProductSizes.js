async function getProductSizes() {
    let response = await fetch('../server/getSizes.php');
    if (response.ok) {
        console.log(response);
        let json = await response.json();
        return json;
    }
}

async function main() {
    try {
        const data = await getProductSizes();
    } catch (error) {
        console.log(error);
    }
}

main();