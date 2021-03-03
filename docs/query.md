# Query String
Filter data in your request to API

## Parameters
* fields: `array ― optional`
* search: `string ― optional`
* page: `integer default(1) ― optional`
* limit: `integer default(25) ― optional`
* relationship: `array ― optional`
* withTrashed: `array ― optional`
* fieldname[where]: `array ― optional`
* fieldname[orwhere]: `array ― optional`
* fieldname[eq]: `string|integer ― optional`
* fieldname[gt]: `string|integer ― optional`
* fieldname[gtEq]: `string|integer ― optional`
* fieldname[lt]: `string|integer ― optional`
* fieldname[ltEq]: `string|integer ― optional`
* fieldname[notEq]: `string|integer ― optional`
* fieldname[like]: `string ― optional`
* fieldname[contain]: `string ― optional`
* fieldname[startwith]: `string ― optional`
* fieldname[endwith]: `string ― optional`
* fieldname[notlike]: `string ― optional`
* fieldname[in]: `array ― optional`
* fieldname[notin]: `array ― optional`
* fieldname[between]: `array ― optional`
* fieldname[notbetween]: `array ― optional`
* fieldname[isnull]: `string ― optional`
* fieldname[isnotnull]: `string ― optional`
* fieldname[orderby]: `array ― optional`


| Query | Parameter | Note |
|---|---|---|
| AND | (where) | WHERE and |
| OR | (orwhere) | WHERE or |
| = | (eq) | EQual |
| > | (gt) | Greater Than |
| >= | (gtEq) | Greater Than EQual |
| < | (lt) | Less Than |
| <= | (ltEq) | Less Than EQual |
| != | (notEq) | NOT EQual |
| LIKE | (like) | LIKE |
| LIKE %...% | (contain) | LIKE %...% |
| LIKE startwith | (startwith) | LIKE startwith% |
| LIKE %endwith | (endwith) | LIKE %endwith |
| NOT LIKE | (notlike) | NOT LIKE |
| IN (...) | (in) | IN |
| NOT IN (...) | (notin) | NOT IN |
| BETWEEN | (between) | BETWEEN |
| NOT BETWEEN | (notbetween) | NOT BETWEEN |
| IS NULL | (isnull) | IS NULL |
| IS NOT NULL | (isnotnull) | IS NOT NULL |
| ORDER BY | (orderby) | ORDER BY |
