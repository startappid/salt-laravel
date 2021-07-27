# Query String
Filter data in your request to API

## Parameters
* fields: `array ― optional`
* search: `string ― optional`
* page: `integer default(1) ― optional`
* limit: `integer default(25) ― optional`
* relationship: `array ― optional`
* withTrashed: `boolean default(false) ― optional`
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


| Query | Parameter | Note | SQL |
|---|---|---|---|
| AND | (where) | WHERE and | ...WHERE 1 = 1 *AND fieldname = {search}*... |
| OR | (orwhere) | WHERE or | ...WHERE 1 = 1 *OR fieldname = {search}*... |
| = | (eq) | EQual | ...WHERE *fieldname = {search}*... |
| > | (gt) | Greater Than | ...WHERE *fieldname > {search}*... |
| >= | (gtEq) | Greater Than EQual | ...WHERE *fieldname >= {search}*... |
| < | (lt) | Less Than | ...WHERE *fieldname < {search}*... |
| <= | (ltEq) | Less Than EQual | ...WHERE *fieldname <= {search}*... |
| != | (notEq) | NOT EQual | ...WHERE *fieldname != {search}*... |
| LIKE | (like) | LIKE | ...WHERE *fieldname LIKE {search}*... |
| LIKE %...% | (contain) | LIKE %...% | ...WHERE *fieldname LIKE %{search}%*... |
| LIKE startwith | (startwith) | LIKE startwith% | ...WHERE *fieldname LIKE {search}%*... |
| LIKE %endwith | (endwith) | LIKE %endwith | ...WHERE *fieldname LIKE %{search}*... |
| NOT LIKE | (notlike) | NOT LIKE | ...WHERE *fieldname NOT LIKE {search}*... |
| IN (...) | (in) | IN | ...WHERE *fieldname IN({search})*... |
| NOT IN (...) | (notin) | NOT IN | ...WHERE *fieldname NOT IN({search})*... |
| BETWEEN | (between) | BETWEEN | ...WHERE *fieldname BETWEEN {search} AND {search}*... |
| NOT BETWEEN | (notbetween) | NOT BETWEEN | ...WHERE *fieldname NOT BETWEEN {search} AND {search}*... |
| IS NULL | (isnull) | IS NULL | ...WHERE *fieldname IS NULL*... |
| IS NOT NULL | (isnotnull) | IS NOT NULL | ...WHERE *fieldname IS NOT NULL*... |
| ORDER BY | (orderby) | ORDER BY | ...ORDER BY *fieldname {orderby}*... |
