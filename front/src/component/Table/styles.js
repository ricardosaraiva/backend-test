import styled from 'styled-components';

const THead = styled.thead``;

const TBody = styled.tbody``;

const Tr = styled.tr``;

const Th = styled.th`
    vertical-align: middle !important; 
`;

const Td = styled.td`
    vertical-align: middle !important; 
`;
const TButtonIcon = styled.button`
    border-radius: 50%;
    padding: 5px 10px;
    margin: 0px;
`;

TButtonIcon.defaultProps = {
    className: 'btn btn-primary'
}

export {
    THead,
    TBody,
    Tr,
    Th,
    Td,
    TButtonIcon
}
